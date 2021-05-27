# https://www.techwithtim.net/tutorials/ai-chatbot
from database import *
import numpy
import tflearn
import random
import json
import pickle
import re
import nltk  # Natural Language Toolkit
from nltk.stem.lancaster import LancasterStemmer
from nltk.tokenize.treebank import TreebankWordDetokenizer
from nltk.tokenize.regexp import RegexpTokenizer
from flask_socketio import emit
stemmer = LancasterStemmer()
import sys
import os

# required_context is a list of all the context that is required to give a response to the user

# list of all responsse for when the bot cannot give a response with a high probability
no_response = ["Sorry, I can't understand you.", "Please, give me more info.", "Not sure I understand."]
no_fallback = ["How can I help you?", "How can I be of service to you?", "What can I do for you?", "How can I assist you?", "How can I be of help to you?"]

#context = { "username": "Pieter" }
context = { }
active_tag = ""
active_tag_list = {}
session_open = True
connections = []

def closeSession(room):
    global context
    context[room] = {}

def orderNumberExtractor(sentence, word, room):
    if re.search("^[B][0-9]*6$", word):
        context[room]["orderNumber"] = word
        return True
    return False

def usernameExtractor(sentence, word, room):
    # https://tim.mcnamara.nz/post/2650550090/extracting-names-with-6-lines-of-python-code
    for sent in nltk.sent_tokenize(sentence):
        for chunk in nltk.ne_chunk(nltk.pos_tag(nltk.word_tokenize(sent))):
            # GPE = location names
            '''if hasattr(chunk, 'label'):
                print(chunk.label(), ' '.join(c[0] for c in chunk.leaves()))'''
            if hasattr(chunk, 'label') and chunk.label() == "PERSON" and word in ' '.join(c[0] for c in chunk.leaves()):
                #print(chunk.label(), ' '.join(c[0] for c in chunk.leaves()))
                context[room]["username"] = ' '.join(c[0] for c in chunk.leaves())
                return True

    return False

def emailExtractor(sentence, word, room):
    # https://stackoverflow.com/questions/39777806/how-to-update-nltk-package-so-that-it-does-not-break-email-into-3-different-toke
    pattern = r'\S+@[^\s.]+\.[a-zA-Z]+|\w+|[^\w\s]'
    tokeniser = RegexpTokenizer(pattern)
    for w in tokeniser.tokenize(sentence):
        if re.search('^(\w|\.|\_|\-)+[@](\w|\_|\-|\.)+[.]\w{2,3}$', w):
            context[room]["email"] = w
            return True
    return False

def yesNoExtractor(sentence, word, room):
    return False

def showPricePage(room):
    respond({"type": "response_page", "data": "Calculate price", "link": "/#title_CalculateRate"}, room)
    print("/#title_CalculateRate")

def printInfoCustomerCare(room):
    respond({"type": "response", "data": "Our Customer Care Team is available through customercare@bluesky.local. Provide details about your issue and information for identification."}, room)
    respond({"type": "response_page", "data": "Contact form", "link": "contact"}, room)


def checkEmail(room):
    print('API CHECK EMAIL')
    del context[room]["email"]

def printAskForOrder(room):
    print("So do you want to place an order now?")

def printOrderStatusCheck(room):
    print("I need to check the status of your order to help you. May I proceed?")

def removeUsername(room):
    del context[room]["username"]

def packageArrival(room):
    # check what yes_no context value is
    if context[room]["yes_no"] == "yes":
        print('API DETAILS HERE')
    del context[room]["yes_no"]

def setContextYes(room):
    context[room]["yes_no"] = "yes"

def setContextNo(room):
    context[room]["yes_no"] = "no"

features = [
    {
        "name": "orderNumber",
        "extractor": orderNumberExtractor,
        "missing_msg": "What is the order number?",
        "Static": False
    },
    {
        "name": "username",
        "extractor": usernameExtractor,
        "missing_msg": "What is your name?",
        "Static": True
    },
    {
        "name": "email",
        "extractor": emailExtractor,
        "missing_msg": "Please give you email?",
        "Static": False
    },
    {
        "name": "yes_no",
        "extractor": yesNoExtractor,
        "missing_msg": "Yes or no?",
        "Static": False
    }
]

# open the json file and read the data
with open("intents.json") as file:
    data = json.load(file)
words = []   # a list with all the words that are in the intents
labels = []  # a list of all the labels
docs_x = []  # a list of all the inputs
docs_y = []  # a list with the matching outputs for each input
features_x = []  # features in the patterns

# loop over all the intents
for intent in data["intents"]:
    # loop over all the patterns
    for pattern in intent["patterns"]:
        # get all the words in the pattern
        words_in_pattern = nltk.word_tokenize(pattern)

        features_in_pattern = set()

        for i, word in enumerate(words_in_pattern):
            if word[0] == '_' and word[len(word) - 1] == '_' and word[1:-1]:
                features_in_pattern.add(word[1:-1])
                words_in_pattern.remove(word)

        features_x.append(features_in_pattern)

        # add all the words to the words list
        words.extend(words_in_pattern)
        # add the list of words in the pattern to the doc_x list (as a nested list)
        docs_x.append(words_in_pattern)
        # add the matching tag to each pattern
        docs_y.append(intent["tag"])

    # add the tag to the labels list
    if intent["tag"] not in labels:
        labels.append(intent["tag"])

# reduce all the words to their root form
words = [stemmer.stem(w.lower()) for w in words if w != "?"]
# remove all the duplicates and sort it
words = sorted(list(set(words)))

# sort the labels list
print(labels)
labels = sorted(labels)

training = []  # a list with all the training data
output = []  # a list with the matching output for each training input

# loop over all the inputs
for x, doc in enumerate(docs_x):
    # create an empty (filled with zeros) list for all the words
    input_words = [0 for _ in range(len(words) + len(features))]

    # reduce all the words of the inputs to their root form
    words_in_input = [stemmer.stem(w.lower()) for w in doc]

    # loop over all  the words
    for i, w in enumerate(words):
        # if the word occurs in the input sentence, set the input to 1
        if w in words_in_input:
            input_words[i] = 1

    # loop over all  the features
    for i, w in enumerate(features):
        # if the feature occurs in the input sentence, set the input to 1
        if w["name"] in features_x[x]:
            input_words[len(words) + i] = 1

    print(input_words)

    # create an empty (filled with zeros) output list for all the labels
    output_row = [0 for _ in range(len(labels))]
    # change the value to 1 with the matching labels
    output_row[labels.index(docs_y[x])] = 1

    # add the input data to the training list
    training.append(input_words)
    # add the output data to the output list
    output.append(output_row)

# transform the lists to numpy array (needed for tensorflow)
training = numpy.array(training)
output = numpy.array(output)


net = tflearn.input_data(shape=[None, len(training[0])])  # input shape
net = tflearn.fully_connected(net, 8)  # hidden layer
net = tflearn.fully_connected(net, 8)  # hidden layer
net = tflearn.fully_connected(net, len(output[0]), activation="softmax")  # output layer
net = tflearn.regression(net)

model = tflearn.DNN(net, tensorboard_verbose=3)

if len(sys.argv) > 1 and sys.argv[1] == "train":
    model.fit(training, output, n_epoch=1000, batch_size=16, show_metric=True, run_id='context_normal')
    model.save("model.tflearn")
else:
    try:
        model.load("model.tflearn")
        print("RELOADED")
    except Exception as e:
        model.fit(training, output, n_epoch=1000, batch_size=16, show_metric=True, run_id='context_normal')
        model.save("model.tflearn")

def bag_of_words(s, words, room):
    # create an empty (filled with zeros) list for all the words
    input_words = [0 for _ in range(len(words) + len(features))]

    # get all the words in the sentance
    words_in_input = nltk.word_tokenize(s)

    # extract context from the sentence
    for word in words_in_input:
        for i, feature in enumerate(features):
            if feature["extractor"](s, word, room):
                input_words[len(words) + i] = 1

    for i, feature in enumerate(features):
        if feature["name"] in context[room].keys():
            input_words[len(words) + i] = 1

    # reduce all the words of the inputs to their root form
    words_in_input = [stemmer.stem(word.lower()) for word in words_in_input]

    # loop over all  the words
    for i, w in enumerate(words):
        # if the word occurs in the input sentence, set the input to 1
        if w in words_in_input:
            input_words[i] = 1
    #print(input_words)

    # return a numpy array
    return numpy.array(input_words)

def featuresInjector(sentence, features):
    words_in_sentence = nltk.word_tokenize(sentence)

    for i, word in enumerate(words_in_sentence):
        if word[0] == '_' and word[len(word) - 1] == '_':
            key = word[1:-1]
            if key in features.keys():
                words_in_sentence[i] = features[key]

    return TreebankWordDetokenizer().detokenize(words_in_sentence)

def aswerTag(tg, room):
    global active_tag_list
    tag = tg["tag"]
    print(tg["tag"])
    response = ""
    noResponse = True
    for cxt in tg['required_context']:
        if cxt not in context[room]:
            if len(active_tag_list[room]) == 0 or active_tag_list[room][-1]["tag"] != tag:
                #print("added " + tag)
                active_tag_list[room].append(tg)

            if "missing_context_msg" in tg and cxt in tg["missing_context_msg"]:
                response = random.choice(tg['missing_context_msg'][cxt])
                noResponse = False
            else:
                response = list(filter(lambda feature: feature["name"] == cxt, features))[0]['missing_msg']
                noResponse = False
            break

    function = None
    if noResponse:
        response = random.choice(tg['responses'])
        if "action_after" in tg:
            function = globals()[tg['action_after']]

    #print(featuresInjector(response, context) + '    [' + tag + ']')
    #print(featuresInjector(response, context))
    respond({"type":"response", "data": featuresInjector(response, context[room])}, room)

    if function != None:
        function(room)

    removedTag = False
    if noResponse and len(active_tag_list[room]) > 0 and active_tag_list[room][-1]["tag"] == tag:
        #print("removed " + tag)
        active_tag_list[room] = active_tag_list[room][:-1]
        removedTag = True

    if noResponse and len(active_tag_list[room]) > 0 and active_tag_list[room][-1]["tag"] != tag:
        #print("Go back: " + active_tag_list[-1]["tag"])
        aswerTag(active_tag_list[room][-1], room)

    if noResponse and len(active_tag_list[room]) == 0 and not removedTag:
        #print("fallback: " + tag + ' ' + random.choice(no_fallback))
        #print(random.choice(no_fallback))
        emit('room_message', {"type":"response", "data": random.choice(no_fallback)}, room=room)

def respond(data, room):
    print("OUT (" + room + "): " + str(data))
    print("Active tags list: " + str(active_tag_list))
    emit('room_message', data, room=room)
    insert_chat( room, "E", str(data['data'])) #save message in database