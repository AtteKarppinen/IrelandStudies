
# coding: utf-8

# This is an attempt at using Python to create a source file for MongoDB.

# https://github.com/datasets/airport-codes

# In[1]:

import pandas as pd
from IPython.display import display
df = pd.read_csv('data/airports.csv', sep = ',', delimiter = None,encoding='latin-1')
city = df[['Country', 'City']].drop_duplicates().sort_values(['Country','City'], ascending = [True,True])


# In[2]:

def writeafile(filename):
    file = open(filename,'w') 
    print('Opening ', filename)
    rec = 'use aviation\n'
    file.write(rec)
    for r, s in thisfile[['Country','City']].itertuples(index=False):
        tc = (df[(df['Country']==r) & (df['City']==s)])
        j = (tc.groupby(['Country','City'], as_index=False)
        .apply(lambda x: x[['AirportId','Name','IATA_FAA', 'ICAO','Latitude','Longitude','Altitude_ft','Timezone','DST']]
               .to_dict('r'))
        .reset_index().to_json(orient='records'))
        rec = 'db.Cities.insert(' + j + ')\n'
        file.write(rec)
    file.close()
    print('Closing ', filename)
    return()


# In[3]:

count = 0
countmax = round(len(city)+.5)/1000
print(countmax)
while (count <= countmax):
    filename = 'data/cityairport' + str(count) + '.js'
    print(filename,'start:',count*1000-1,' end: ', count*1000 + 999)
    thisfile = city[count*1000 -1: count*1000 + 999]
    print(thisfile.head())
    print ('The count is:', count)
    b = writeafile(filename)
    count = count + 1

print ("Good bye!")

