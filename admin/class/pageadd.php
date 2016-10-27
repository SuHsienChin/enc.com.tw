<?php


function addpage($arr){
    $newarr = $arr;

    foreach ($arr as $item) {
        switch($item){
            case "account.php":
                array_push($newarr,"accountAdd.php");
                array_push($newarr,"accountEdit.php");
                array_push($newarr,"accountDel.php");

                break;
            case "webinfo.php":

                break;
            case "copyrightInfo.php":

                break;
            case "webSeo.php":

                break;
            case "setSlider.php":
                array_push($newarr,"sliderEdit.php");

                break;
            case "sidead.php":
                array_push($newarr,"sideadAdd.php");
                array_push($newarr,"sideadEdit.php");
                array_push($newarr,"sideadDel.php");

                break;
            case "article.php":
                array_push($newarr,"articleEdit.php");
                array_push($newarr,"countryEdit.php");
                array_push($newarr,"country_sort.php");
                array_push($newarr,"countryAdd.php");
                break;
            case "about.php":
                array_push($newarr,"aboutAdd.php");
                array_push($newarr,"aboutEdit");
                array_push($newarr,"aboutDel.php");

                break;
            case "setnews.php":
                array_push($newarr,"newsAdd.php");
                array_push($newarr,"newsEdit.php");
                array_push($newarr,"newsDel.php");
                break;
            case "qandaclass.php":
                array_push($newarr,"qandaclassAdd.php");
                array_push($newarr,"qandaclassDel.php");
                array_push($newarr,"qandaclassEdit.php");
                break;
            case "qanda.php":
                array_push($newarr,"qandaAdd.php");
                array_push($newarr,"qandaDel.php");
                array_push($newarr,"qandaEdit.php");

                break;
            case "downloadclass.php":
                array_push($newarr,"dlEdit.php");
                array_push($newarr,"dlDel.php");
                array_push($newarr,"dlclassAdd.php");

                break;
            case "dlfile.php":
                array_push($newarr,"dlfAdd.php");
                array_push($newarr,"dlfEdit.php");

                break;
            case "contactus.php":
                array_push($newarr,"contactusEdit.php");
                break;
            case "advisory.php":
                array_push($newarr,"advisoryEdit.php");

                break;
            case "link.php":
                array_push($newarr,"linkAdd.php");
                array_push($newarr,"linkDel.php");
                array_push($newarr,"linkEdit.php");

                break;

        }


    }

    $_SESSION['pages']=$newarr;
}