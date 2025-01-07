import pyfiap

fiap = pyfiap.fiap.APP("http://iot.info.nara-k.ac.jp/axis2/services/FIAPStorage?wsdl")

result = fiap.fetch_latest('http://tokuda.yamaken/co2_lifting')
for data in result :
    print(data["time"])