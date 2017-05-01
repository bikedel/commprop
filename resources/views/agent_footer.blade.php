<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>


html,body,h1,h2,h3,h4,h5,table,td,th,tr {
    font-family: "Raleway", sans-serif;
    padding:0px !important;
     font-size: 0.89em;
}

td {
    padding:5px;
}

h4 {
    font-size: 1em;
  font-weight: 700;
  font-family: 'Raleway Bold', sans-serif;
   padding:0px !important;
    display:inline;
    margin:0px;
}

 hr { margin:  0px 0px; }

.imgfooter {


border: 10 solid blue !important;

}
.right{
    float:right;
}
@media print {
  footer {
    position: fixed;
    bottom: 0;
  }

  .content-block, p {
    page-break-inside: avoid;
  }

  html, body {
    width: 210mm;
    height: 297mm;
  }
}
</style>
</head>
<body>

<table>

    <tbody>

    <tr>
    <hr>
    </tr>
        <tr style="width:210mm" >

            <td valign="top"><img class="imgfooter" src='{{$agent->photo}}' style="width:25mm;height:30mm;" ></td>
             <td valign="top" style="width:5mm"></td>
            <td valign="top" style="width:90mm">
             <strong><br><b><h4>{{$agent->name}}</h4></b></strong><br>Director<br><b>Commercial – Industrial - Retail</b><br>24 Protea Road, Claremont<br>Tel: Tel: +27 (0) 21 673 1240 <b>Fax: </b>+27 (0) 21 671 4275 <br>Mobile: +27 (0) {{$agent->cell}}<br>Email: {{$agent->email}}

            </td>
            <td valign="top" style="width:40mm"></td>
            <td valign="top" class="pull-right right"></td>

        </tr>


    </tbody>
</table>

<img src = "img/sothebys_banner.png" width="800" />


</body>
</html>
