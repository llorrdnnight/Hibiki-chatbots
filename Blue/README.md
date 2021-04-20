# Blue
Blue is currently a very simple python (3.6) contextual chatbot.
Based on a tutorial from ["tech with Tim"](https://www.youtube.com/watch?v=wypVcNIH6D4&list=PLzMcBGfZo4-ndH9FoC4YWHGXG5RZekt-Q)

### the contextual
Blue will be situated on the website of "Blue Sky Unlimited", were it will act as a tool for customers to
find answer to question / simple directions.

## Possible Improvements
* Response Suggestion
Give the user a set of optional suggested answers (drive them in a right direction).

* Answer "prediction"
For the session keep track of all intents visited and in what order, use this data as input to a new NN to predict the most likely next intend the user will be heading to.

* Dynamic no matching intent
Make a 'default' intent case for when no matching intent is found, therefore have more than 1 response available in the same data format as intents.

## Impossible Improvements
* Dynamically learn new intents
Through its experience the chatbot will keep track of questions for which it did not find the right intents, and try to group them together in what would be new possible intents.

This one seems very unlikely and above the scope of our work / timeframe. And in general very complex.
