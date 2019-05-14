<?php

global $data;
$data="default";
$pkeyword="data retained";

$pnew=false;
$pused=false;
$punspecified=false;
$penable=false;
$pfreeship=false;
$plocalpickup=false;
$pcategory="";
$testdata='lkfjdkl';
$penable=false;
$pmiles="10";
$phere=false;
$pthere=false;
$ptherezipcode="sdsad";
?>



 <?php 
 if(isset($_POST['hiddensubmit'])){
    
    $secondUrl="http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=JSON&appid=MohitSha-wewrf-PRD-516de56b6-67124a5f&siteid=0&version=967&ItemID=";
    $secondUrl=$secondUrl.$_POST['productIdHidden']."&IncludeSelector=Description,Details,ItemSpecifics";
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $secondUrl);
  //curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
  //$output contains the output json
  $output2 = curl_exec($ch2);
  $data2=json_encode($output2);
  curl_close($ch2);

  $thirdurl="http://svcs.ebay.com/MerchandisingService?OPERATION-NAME=getSimilarItems&SERVICE-NAME=MerchandisingService&SERVICE-VERSION=1.1.0&CONSUMER-ID=MohitSha-wewrf-PRD-516de56b6-67124a5f&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&itemId=".$_POST['productIdHidden']."&maxResults=8";
  $ch3 = curl_init();
  curl_setopt($ch3, CURLOPT_URL, $thirdurl);

curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);

$output3 = curl_exec($ch3);
$data3=json_encode($output3);
curl_close($ch3);
$testdata=json_decode($_POST['persistData']);
$pkeyword=$testdata->keyword;

$pnew=$testdata->pnew;
$pused=$testdata->pused;
$punspecified=$testdata->punspecified;
$penable=$testdata->keyword;
$pfreeship=$testdata->pfree;
$plocalpickup=$testdata->plocalpick;
$pcategory=$testdata->pcategory;
$penable=$testdata->penable;
$pmiles=$testdata->pmiles;
$phere=$testdata->phere;
$pthere=$testdata->pthere;
$ptherezipcode=$testdata->ptherezipcode;
  
}

 $url="mn,mn,mn";
 if(isset($_POST['search'])){
    $keyWord=rawurlencode($_POST['keyword']);
    
    if(isset($_POST['enableSearch']))
    {
        $distance=$_POST['miles'];
        $pmiles=$_POST['miles'];
        $penable=true;
        if(isset($_POST['Here'])&&$_POST['Here']=="Here"){
            $zip=$_POST['location'];
            $phere=true;
            
        }
        else{
            $pthere=true;
            $ptherezipcode=$_POST['zipBox'];
            $zip=$_POST['zipBox'];
        }
    }
    else{
        $penable=false;
        $zip="";
    }
    $c ="hi php";
    $count=0;
    $ch = curl_init();
    $shipping;
    
    $categoryMapping = array();
    $categoryMapping["Art"] = "550";
    $categoryMapping["Baby"] = "2984";
    $categoryMapping["Books"] = "267";
    $categoryMapping["Clothing, Shoes & Accessories"] = "11450";
    $categoryMapping["Computers/Tablets & Networking"] = "58058";
    $categoryMapping["Health & Beauty"] = "26395";
    $categoryMapping["Music"] = "11233";
    $categoryMapping["Video Games & Consoles"] = "1249";

    $url="http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=MohitSha-wewrf-PRD-516de56b6-67124a5f&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&paginationInput.entriesPerPage=20";
    $url=$url."&keywords=".$keyWord;
    $pkeyword=$_POST['keyword'];
    if($_POST['categories']!='All Categories'){
        $url=$url."&categoryId=".$categoryMapping[$_POST['categories']];
        $pcategory=$_POST['categories'];
        
    }
    else{
        $pcategory=$_POST['categories']; 
    }
    
    if(isset($_POST['enableSearch'])){
        $url=$url."&buyerPostalCode=".$zip;
        $url=$url."&itemFilter(".$count.").name=MaxDistance&itemFilter(".$count.").value=".$distance;
        $count=$count+1;
        $pzip=$zip;
    }
    if(isset($_POST['localPick'])){
        $url=$url."&itemFilter(".$count.").name=LocalPickupOnly&itemFilter(".$count.").value=true";
        $count=$count+1;
        $plocalpickup=$_POST['localPick'];
    }
    if(isset($_POST['freeShip'])){
        $url=$url."&itemFilter(".$count.").name=FreeShippingOnly&itemFilter(".$count.").value=true";
        $count=$count+1;
        $pfreeship=$_POST['freeShip'];
    }
    $innercount=0;
    $shipping=array();
    
    if(isset($_POST['New'])){
        array_push($shipping,"New");
        $pnew=true;
    }
    if(isset($_POST['Unspecified'])){
        array_push($shipping,"Unspecified");
        $punspecified=true;
    }
    if(isset($_POST['Used'])){
        array_push($shipping,"Used");
        $pused=true;
    }
    if(count($shipping)>0){
        $url=$url."&itemFilter(".$count.").name=Condition";
        foreach ($shipping  as $value) {
            $url=$url."&itemFilter(".$count.").value(".$innercount.")=".$value;
            $innercount++;
        }
        $count=$count+1;
    }
    
    $url=$url."&itemFilter(".$count.").name=HideDuplicateItems"."&itemFilter(".$count.").value=true";
    $count=$count+1;
    
  curl_setopt($ch, CURLOPT_URL, $url);
  //curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //$output contains the output json
  $output = curl_exec($ch);
  
  $data = json_encode($output);
  // close curl resource to free up system resources 
  curl_close($ch);
}


    
  

?>
<html>
<head>
<style>
    #sellerabcd,#similarabcd{
        margin: 10px;
    }
    #hiddensubmit{
        visibility:hidden;
    }
body{
    top: 200px;
    margin: 0 auto;
    text-align:center;
}
#form1{
    left: 200px;
    border: 2px solid #c6c4c5;
    display:inline-block;
    background-color: #faf8fb;
    padding: 10px;
    
}
#simiTable td{
    padding: 10px;
   
}
#norecords,#invalidIdvalue{
    border: 2px solid #c6c4c5;
    background-color: #faf8fb;
    padding: 10px;
    width:900px;
    color:black;
    margin: 0 auto;
}
#nomessage{
    border: 2px solid #c6c4c5;
    
    padding: 10px;
    width:900px;
    color:black;
    margin: 0 auto;
}
h1{
    line-height:15px;
    margin : 0px;
    text-align: center;
}
p{
    color: #9d9c9d;
    margin: 0px;
}
#tI,.tableInitial{
    margin: 20px;
}
#simiDiv { 
    
    width:750px; 
    overflow: auto; 
    margin: 0 auto;
    }
   
a:link,a:visited,a:active{
    text-decoration:none;
    color:black;
    
}
input:disabled{
    opacity:0.5;
}
a:hover{
        text-decoration:none;
        color:#c6c4c5;
}
table{
    border-collapse: collapse;
    border: 2px solid #c6c4c5;
}


</style>
</head>
<body>
    <div>
<form id="form1" method="post" action="index.php">
<h1> <i>Product Search </i></h1>
<hr>
<br><br>
<b>Keyword:<input type="text" required  id="keyword" name="keyword"></b>
<br><br>
<b>Category:</b> 
<select name="categories" id="categoryid">
<option value="All Categories" selected>All Categories</option>
  <option value="Art">Art</option>
  <option value="Baby">Baby</option>
  <option value="Books" >Books</option>
  <option value="Clothing, Shoes & Accessories">Clothing, Shoes & Accessories</option>
  <option value="Computers/Tablets & Networking">Computers/Tablets & Networking</option>
  
  <option value="Health & Beauty">Health & Beauty</option>
  
  <option value="Music">Music</option>
  <option value="Video Games & Consoles">Video Games & Consoles</option>
  </select>
  <br><br><b>Condition:</b>
  <input type="checkbox" name="New" value="New" id="new"> New 
  <input type="checkbox" name="Used" value="Used" id="used"> Used
  <input type="checkbox" name="Unspecified" value="Unspecified" id="unspecified"> Unspecified
  <br> <br><strong>Shipping Option:</strong>
  <input type="checkbox" name="localPick" value="Local Pickup" id="localPick"> Local Pickup
  <input type="checkbox" name="freeShip" value="Free Shipping" id="freeShip"> Free Shipping
  <br><br>
  <input type="checkbox" name="enableSearch" id="enableSearch" value="Enable Search" onchange="enable()"> <b>Enable Nearby Search
<input type="number" value="10" min="0" id="enab1" name="miles" style='width:50px'> miles from 
<input type="radio" name="Here" value="Here"  id="Here" onchange="enable()" checked=true> Here
<br><br>&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195&#8195
<input type="radio" name="Here" value="NoVal" id="enab3"  onchange="enable()" > 
<!-- ZIP CODE field box -->
<input type="text" id="enab4" placeholder="zip code" minlength='5' maxlength='5' required name="zipBox"> 
<input type="hidden" id="location" name="location">
<script>
document.getElementById("enab1").disabled=true;
document.getElementById("Here").disabled=true;
        document.getElementById("enab3").disabled=true;
        document.getElementById("enab4").disabled=true;
</script>

<br><br> <input type="submit"  id="s1" name="search" value="Search">
<input type="button" id='c1' value="Clear" onclick="reset1()">
</form>
</div>
</body>
</html>
<script>
document.getElementById("s1").disabled=true;
function locationFetch(){
    data="h1";
    
    var xhrq = new XMLHttpRequest();
    xhrq.open("GET", "http://ip-api.com/json", false);
    xhrq.send();

    jsonDoc = xhrq.responseText;
            jsonObj = JSON.parse(jsonDoc);
            
            zipcode=jsonObj.zip;
          
            document.getElementById("location").value=zipcode;
            document.getElementById("s1").disabled=false;
       
}
locationFetch();

</script>




<div class="tableInitial">
    <p id="tI">
    
    </p>
</div>
<div>
    <form id="productTable" method="post" action="index.php">
        <input type="hidden" id="productIdHidden" name="productIdHidden">
        <input type="hidden" id="persistData" name="persistData">
        <input type="submit" id="hiddensubmit" name="hiddensubmit">
    </form> 
</div>
<script type='text/javascript' >
function reset1() {
    document.getElementById('keyword').value="";
    
    document.getElementById('new').checked=false;
   
   document.getElementById('used').checked=false;
    
document.getElementById('unspecified').checked=false;

   document.getElementById('freeShip').checked=false;
    
 document.getElementById('localPick').checked=false;

    document.getElementById('categoryid').value="All Categories";
  
   document.getElementById('enableSearch').checked=false;
   enable();
    
   document.getElementById('tI').innerHTML="";
}
function productTable1(data){
    var perkeywordvalue=document.getElementById('keyword').value;
    
    var pernew=document.getElementById('new').checked;
    
    var perused=document.getElementById('used').checked;
 
    var perunspecified=document.getElementById('unspecified').checked;

    var perfree=document.getElementById('freeShip').checked;
    
    var perlocalpick=document.getElementById('localPick').checked;
    
    var percategory=document.getElementById('categoryid').value;
    var perenableSearch=document.getElementById('enableSearch').checked;
    var permiles=document.getElementById('enab1').value;
    var perhere=document.getElementById('Here').checked;
    var perthere=false;
    var pertherezipcode="dsad";
    if(!perhere){
        perthere=false;
        pertherezipcode=document.getElementById('enab4').value;
    }
    var pdata={};
        pdata.keyword=perkeywordvalue;
        pdata.pnew=pernew;
        pdata.pused=perused;
        pdata.punspecified=perunspecified;
        pdata.pfree=perfree;
        pdata.plocalpick=perlocalpick;
        pdata.pcategory=percategory;
        pdata.penable=perenableSearch;
        pdata.pmiles=permiles;
        pdata.phere=perhere;
        pdata.pthere=perthere;
        pdata.ptherezipcode=pertherezipcode;
    document.getElementById("productIdHidden").value=data;
    document.getElementById("persistData").value=JSON.stringify(pdata);

 
    document.getElementById("hiddensubmit").click();
}
function persistData(){
    var pkeyword=document.getElementById('keyword');
    pkeyword.value="<?php echo $pkeyword ?>";
    var pnew=document.getElementById('new');
    pnew.checked=<?php echo $pnew?'true':'false' ?>;
    var pused=document.getElementById('used');
    pused.checked=<?php echo $pused?'true':'false' ?>;
    var punspecified=document.getElementById('unspecified');
    punspecified.checked=<?php echo $punspecified?'true':'false' ?>;
    var pfree=document.getElementById('freeShip');
    pfree.checked=<?php echo $pfreeship?'true':'false' ?>;
    var plocalpick=document.getElementById('localPick');
    plocalpick.checked=<?php echo $plocalpickup?'true':'false' ?>;
    var pcategory=document.getElementById('categoryid');
    pcategory.value="<?php echo $pcategory ?>";
    var penable=document.getElementById('enableSearch');
    penable.checked=<?php echo $penable?'true':'false' ?>;
    var phere=<?php echo $phere?'true':'false'?>;
    var pmiles="<?php echo $pmiles ?>;"
    if(penable.checked===true){
        document.getElementById("enab1").disabled=false;
        document.getElementById("enab1").value="<?php echo $pmiles ?>";
        if(phere){
            document.getElementById('Here').disabled=false;
            document.getElementById('enab3').disabled=false;
            document.getElementById('Here').checked=true;
        }else{
            document.getElementById('enab3').disabled=false;
            document.getElementById('Here').disabled=false;
            document.getElementById('enab3').checked=true;
            document.getElementById('enab4').disabled=false;
            document.getElementById('enab4').value="<?php echo $ptherezipcode ?>";

        }
    }
}
function similarItems(){
    var simiData=<?php echo json_encode($data3) ?>;
    
    var simiProducts=JSON.parse(simiData);
    var simiparse=JSON.parse(simiProducts);
    
    var sellImg=document.getElementById('imgSellMessage');
 
    var simiImg=document.getElementById('imgSimiMessage');
    if(simiImg.getAttribute('src')==='http://csci571.com/hw/hw6/images/arrow_down.png'){
        if(sellImg.getAttribute('src')==='http://csci571.com/hw/hw6/images/arrow_up.png'){
            sellImg.src="http://csci571.com/hw/hw6/images/arrow_down.png";
            document.getElementById("sellerMessageDiv").innerHTML="";
            document.getElementById("sellerabcd").innerHTML="click to show the seller message";
        }
            simiImg.src="http://csci571.com/hw/hw6/images/arrow_up.png";
            document.getElementById("similarabcd").innerHTML="click  to hide the similar images";
            //simiDiv
            try{
                var similarData=simiparse.getSimilarItemsResponse.itemRecommendations.item;
                if(similarData.length==0){
                document.getElementById("simiDiv").innerHTML="<div id='nomessage' > No Similar Items Found</d>";
            }
            
            
            else{
                var simiTable="<table  id='simiTable' align='center' ><tr>";
                var i=0;
            for( i=0;i<similarData.length;i++){
               
                simiTable+="<td height=200><img src='"+similarData[i].imageURL+"'><br><a href='#' onclick='productTable1("+similarData[i].itemId+")'>" 
                +similarData[i].title+"</a></td>";
            }
            simiTable=simiTable+"</tr>";
            simiTable=simiTable+"<tr>";
            for( i=0;i<similarData.length;i++){
                simiTable+="<td><b>$"+similarData[i].buyItNowPrice.__value__+"</td>";
            }
            simiTable=simiTable+"</tr></table>";
            document.getElementById("simiDiv").innerHTML=simiTable;
            }
            
         }
         catch{
            document.getElementById("simiDiv").innerHTML="Error Fetching Similar Items. Please try again later.";
         }
            
        }
        else{
            simiImg.src="http://csci571.com/hw/hw6/images/arrow_down.png";
            document.getElementById("similarabcd").innerHTML="click  to show the similar images";
            document.getElementById("simiDiv").innerHTML="";
        }

}
function sellerMessage(){
   
    var sellImg=document.getElementById('imgSellMessage');
    var simiImg=document.getElementById('imgSimiMessage');
    if(sellImg.getAttribute('src')==='http://csci571.com/hw/hw6/images/arrow_down.png'){
        sellImg.src="http://csci571.com/hw/hw6/images/arrow_up.png";
        document.getElementById("sellerabcd").innerHTML="click  to hide the seller message";
        if(simiImg.getAttribute('src')==='http://csci571.com/hw/hw6/images/arrow_up.png'){
            simiImg.src="http://csci571.com/hw/hw6/images/arrow_down.png";
            document.getElementById("simiDiv").innerHTML="";
            document.getElementById("similarabcd").innerHTML="click  to show the similar images";
        }
        else{

        }
        var unpdesc=<?php echo json_encode($data2) ?>;
        var pdesc=JSON.parse(unpdesc);
        var finalpdesc=JSON.parse(pdesc);
        try{
            
            var desc=finalpdesc.Item.Description;
            if(desc===""){
                document.getElementById('sellerMessageDiv').innerHTML="<div id='nomessage'> No Seller Message Found</d>";
            }else{
                var b = desc.replace(/'/g, '"');
        var iframe="<iframe id='iframe1' frameBorder='0' onload='this.height=this.contentWindow.document.body.offsetHeight;' width='1200'srcdoc='"+b+"'>";
      
        document.getElementById('sellerMessageDiv').innerHTML=iframe;
            }
       
        }
        catch{
            document.getElementById('sellerMessageDiv').innerHTML="<div id='nomessage'> Error Fetching Description of the Product</d>";
        }
        
    }
    else{
        sellImg.src="http://csci571.com/hw/hw6/images/arrow_down.png";
        document.getElementById("sellerabcd").innerHTML="click to show the seller message";
        document.getElementById("sellerMessageDiv").innerHTML="";  
    }
}

/////////----------------------------Table Generation COde==========================
function generateProductTable() {
    persistData();
  

    var data2=<?php echo json_encode($data2) ?>;
    var rawProductData=JSON.parse(data2);
    var reparse=JSON.parse(rawProductData);
    if(reparse.Ack==="Failure"){
        document.getElementById("tI").innerHTML="<div class='invalidIdvalue'> Unable to Fetch Data due to Invalid ID </div>";
    }
    else{
        var productData=reparse['Item'];

    
    var htmlTable;
    htmlTable="<h2 style='color:black'> Item Details</h2>"
    htmlTable+="<table id='indiTable' border='2px' align='center'>";
    if(productData.PictureURL[0]!=undefined){
        htmlTable=htmlTable+"<tr><td height='175'><b>Photo</b></td><td height='150'><img height='150' src='"+productData.PictureURL[0]+"'></td></tr>";
    }
    if(productData.Title!=undefined){
        htmlTable=htmlTable+"<tr><td><b>Title</b></td><td>"+productData.Title+"</td></tr>";
    }
    if(productData.SubTitle!=undefined){
        htmlTable=htmlTable+"<tr><td><b>Subtitle</b></td><td>"+productData.SubTitle+"</td></tr>";
    }
    if(productData.CurrentPrice.Value!=undefined){
        htmlTable=htmlTable+"<tr><td><b>Price</td></b><td>$"+productData.CurrentPrice.Value+" USD</td></tr>";
    }
    if(productData.Location!=undefined){
        htmlTable=htmlTable+"<tr><td><b>Location</td></b><td>"+productData.Location+"</td></tr>";
    }
    if(productData.Seller.UserID!=undefined){
        htmlTable=htmlTable+"<tr><td><b>Seller</b></td><td>"+productData.Seller.UserID+"</td></tr>";
    }
    if(productData.ReturnPolicy.Refund!=undefined){
        htmlTable=htmlTable+"<tr><td><b>Return Policy (US)</b></td><td>"+productData.ReturnPolicy.Refund+"</td></tr>";
    }
    
        try{
            var keyArray=productData.ItemSpecifics.NameValueList;
        for(var i=0;i<keyArray.length;i++){
        htmlTable=htmlTable+"<tr><td><b>"+keyArray[i].Name+"</b></td><td>"+keyArray[i].Value[0]+"</td></tr>";
        }
        for(var i=0;i<keyArray.length;i++){
        htmlTable=htmlTable+"<tr><td><b>"+keyArray[i].Name+"</b></td><td>"+keyArray[i].Value[0]+"</td></tr>";
        }
     }
        catch{
            htmlTable=htmlTable+"<tr><td><b>No Detail info from seller</b></td><td style='background-color:#d9d8da'></td></tr>";
        }
        
    htmlTable=htmlTable+"</table>";
    document.getElementById("tI").innerHTML=htmlTable;
    var para = document.createElement("P");   
    para.id="sellerabcd";                  
    var text = document.createTextNode("click to show seller message");      
    para.appendChild(text);                              
    var img=document.createElement("img");
    img.setAttribute('id','imgSellMessage');
    img.setAttribute('src','http://csci571.com/hw/hw6/images/arrow_down.png');
    img.setAttribute('height', '25px');
    img.setAttribute('width', '40px');
    img.setAttribute('onclick','sellerMessage()');
    var sellDiv=document.createElement("div");
    sellDiv.setAttribute('id','sellerMessageDiv');
    document.getElementById("tI").appendChild(para);    
    document.getElementById("tI").appendChild(img);  
    document.getElementById("tI").appendChild(sellDiv);  
    var para2 = document.createElement("P");      
    para2.id="similarabcd";               
    var text2 = document.createTextNode("click to show similar items");      
    para2.appendChild(text2);                              
    var img2=document.createElement("img");
    img2.setAttribute('id','imgSimiMessage');
    img2.setAttribute('src','http://csci571.com/hw/hw6/images/arrow_down.png');
    img2.setAttribute('height', '25px');
    img2.setAttribute('width', '40px');
    img2.setAttribute('onclick','similarItems()');
    var simiDiv=document.createElement("div");
    simiDiv.setAttribute('id','simiDiv');
    document.getElementById("tI").appendChild(para2);    
    document.getElementById("tI").appendChild(img2);  
    document.getElementById("tI").appendChild(simiDiv);  

}
}
/////////-----------PRODUCT TABLE FORM  ----------------/////////

function enable(){
   
        var box= document.getElementById("enableSearch").checked;
    if(box){
        document.getElementById("enab1").disabled=false;
        document.getElementById("Here").disabled=false;
        document.getElementById("enab3").disabled=false;
        if(document.getElementById("enab3").checked){
            document.getElementById("enab4").disabled=false;
        }
        else{
            document.getElementById("enab4").disabled=true;
            document.getElementById("enab4").value="";
        }
    }
    else{
        document.getElementById("enab1").disabled=true;
        document.getElementById("Here").disabled=true;
        document.getElementById("enab3").disabled=true;
        document.getElementById("enab4").disabled=true;
        document.getElementById("enab4").value="";
    }
 }
    
    

function submit1(){
   persistData();

   var char=<?php echo json_encode($data) ?>;
   var obj = JSON.parse(char);
   var parsedData=JSON.parse(obj);
   
   if(parsedData.findItemsAdvancedResponse[0].ack[0]==="Failure"){
    document.getElementById("tI").innerHTML="<div id='norecords'>Zipcode is invalid </div>";
   }
   else{
    var checkData=parsedData.findItemsAdvancedResponse[0].searchResult[0];
   if(checkData['@count']==0){
       
       document.getElementById("tI").innerHTML="<div id='norecords'> No Records has been found</div>";
   }
   else{
    var responseData=parsedData.findItemsAdvancedResponse[0].searchResult[0].item;
  
   var htmlData="<table id='originTable' border='2px' align='center'>";
   htmlData+="<tr>";
   htmlData+="<th>Index</th>";
   htmlData+="<th>Photo</th>";
   htmlData+="<th>Name</th>";
   htmlData+="<th>Price</th>";
   htmlData+="<th>Zip Code</th>";
   htmlData+="<th>Condition</th>";
   htmlData+="<th>Shipping Option</th>";
   htmlData+="</tr>";

   var i;
   for(i=0;i<responseData.length;i++){
        htmlData=htmlData+"<tr>";
        htmlData=htmlData+"<td>"+(i+1)+"</td>";
        if(responseData[i].hasOwnProperty("galleryURL")){
            htmlData=htmlData+"<td><img src='"+ responseData[i].galleryURL[0]+"'/></td>";
        }
        else{
            htmlData=htmlData+"<td>N/A</td>";
        }
        
        htmlData=htmlData+"<td> <a href='#' onclick='productTable1("+responseData[i].itemId[0]+")'>"+responseData[i].title[0]+"</a></td>";
       
        htmlData=htmlData+"<td>$"+responseData[i].sellingStatus[0].currentPrice[0].__value__+"</td>";
        if(responseData[i].hasOwnProperty("postalCode")){
            htmlData=htmlData+"<td>"+responseData[i].postalCode+"</td>";
        }
        else{
            htmlData=htmlData+"<td>N/A</td>";
        }
        if(responseData[i].hasOwnProperty("condition")){
            htmlData=htmlData+"<td>"+responseData[i].condition[0].conditionDisplayName[0]+"</td>";
        }
        else{
            htmlData=htmlData+"<td>N/A</td>";
        }
        try{
            var value=responseData[i].shippingInfo[0].shippingServiceCost[0].__value__;
            if(value==0.0){
            htmlData=htmlData+"<td>Free Shipping</td>";
            }
            else{
            htmlData=htmlData+"<td>$"+value+"</td>";
            }
        }
        catch{
            htmlData=htmlData+"<td>N/A</td>";
        }
        
        
        
        htmlData=htmlData+"</tr>";
   }
   document.getElementById("tI").innerHTML=htmlData;
   }
   }
   
   

 

}
</script>
<?php 
if(isset($_POST['hiddensubmit'])){
    echo "<script>";
    echo "generateProductTable();";
    echo "</script>";
}?>

<?php if(isset($_POST['search'])) {
        echo '<script language="javascript">';
        echo 'submit1();' ;
        echo '</script>';
    }
    
?>



