Dim o
Set o = CreateObject("MSXML2.XMLHTTP")
o.open "GET", "http://target_url", False
o.send
