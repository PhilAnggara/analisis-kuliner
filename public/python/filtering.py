# import nltk
# nltk.download('stopwords')
from pprint import pprint
from nltk.corpus import stopwords

data_token = ['mulutnya','terbuka','mendesiskan','suara','yang','tak','berbentuk','kata']

def stopword_removal(comments):
  filtering = stopwords.words('indonesian','english')
  x = []
  def myFunc(x):
    if x in filtering:
      return False
    else:
      return True
  fit = filter(myFunc, comments)
  data = []
  for x in fit:
    data.append(x)
  return data

data_filtered = stopword_removal(data_token)

pprint(data_filtered)