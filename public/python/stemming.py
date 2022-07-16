from pprint import pprint
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory

data_filtered = ['mulutnya', 'terbuka', 'mendesiskan', 'suara', 'berbentuk']

def stemming(comments):
  factory = StemmerFactory()
  stemmer = factory.create_stemmer()
  data = []
  for w in comments:
    dt = stemmer.stem(w)
    data.append(dt)
  return data

data_stemmed = stemming(data_filtered)

pprint(data_stemmed)