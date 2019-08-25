Athlete {
    Name,
    Country,
    Gender,
    Medal
}

Competition {
    City,
    Edition,
    Sport,
    Discipline,
    Event,
    Event_gender
}

AthletePython {
    Name,
    Country,
    Gender,
    Medals [
        CompetitionPython_id,
        Medal
    ]
}

CompetitionPython {
    City,
    Edition,
    Sport,
    Discipline,
    Event,
    Event_gender
}

db.AthletePython.find().pretty()                                // Finds everything
db.AthletePython.find({ "Medals.Medal":"Gold" }).pretty()       // Finds all gold medallists
db.AthletePython.find({}, {"Medals":1, "_id":0}).pretty()       // Finds only embedded data minus _id

db.AthletePython.update({"Name":"HAJOS, Alfred"}, {$set:{"Dual_Citizenship":"No"}})     // Sets one new field
