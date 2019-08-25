#!/usr/bin/env python
import os
import pandas as pd
import pymongo
import json



def import_content(filepath):
    mongoClient     = pymongo.MongoClient('localhost', 27017)   # Default: localhost and port 27017
    mongoDB         = mongoClient['OlympicGames']               # Mongo db name
    athletes        = 'AthletePython'                           # Mongo db collection name
    competition     = 'CompetitionPython'
    dbAthlete       = mongoDB[athletes]
    dbCompetition   = mongoDB[competition]
    currentDir      = os.path.dirname(__file__)
    file_res        = os.path.join(currentDir, filepath)

    data            = pd.read_csv(file_res)
    data_json       = json.loads(data.to_json(orient='records'))
    i = 0
    dbAthlete.delete_many({})                                   # Remove collection if exists
    dbCompetition.delete_many({})

    while i < len(data_json):                                   # Loop through all records
        competitionInfo = {
            "City":         data_json[i]['City'],
            "Year":         data_json[i]['Edition'],
            "Sport":        data_json[i]['Sport'],
            "Discipline":   data_json[i]['Discipline'],
            "Event":        data_json[i]['Event'],
            "Event_gender": data_json[i]['Event_gender']
        }
        insertedRow = dbCompetition.insert_one(competitionInfo) # Property inserted_id holds the id of the inserted document

        athleteInfo = {
            "Name":         data_json[i]['Name'],
            "Country":      data_json[i]['Country'],
            "Gender":       data_json[i]['Gender'],
            "Medals": {
                "sport_id": insertedRow.inserted_id,            # Reference to competition where medal was won
                "Medal":    data_json[i]['Medal']
            }
        }
        messageA = dbAthlete.insert_one(athleteInfo)            # Save result to see if successful
        print(insertedRow, messageA)
        i += 1


if __name__ == "__main__":                                      # Runs only if script is executed directly
    filepath = 'Summer_Olympic_medallists.csv'
    import_content(filepath)