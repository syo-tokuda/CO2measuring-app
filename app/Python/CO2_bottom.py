import pyfiap
import datetime
import sys

# JST = datetime.timezone(datetime.timedelta(hours=+9), 'JST')
args = sys.argv
fromdate = datetime.datetime.now().replace(hour=0,minute=0,second=0,microsecond=0) - datetime.timedelta(days=int(args[1])*-1) + datetime.timedelta(hours=int(args[2]))
todate = fromdate + datetime.timedelta(hours=int(args[3]))

fiap = pyfiap.fiap.APP("http://iot.info.nara-k.ac.jp/axis2/services/FIAPStorage?wsdl")

result = fiap.fetch_by_time('http://tokuda.yamaken/co2_bottom', fromdate, todate)
for data in result :
    print(data["value"])