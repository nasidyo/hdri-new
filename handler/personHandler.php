<?php
require_once '../service/person.php';
require_once '../model/PersonM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $personM = new PersonM();
            $landM = new LandM();
            $seqService = new SeqService();
            $seqPerson= $seqService->get("person_id_seq");


            if (isset($_POST['area'])) {
                $personM->setArea_idArea($_POST['area']);
            }

            if (isset($_POST['agriList'])) {
                $agriList=$_POST['agriList'] ;
                $personM->setAgriList($agriList);
            }

            if (isset($_POST['earnPay'])) {

                $data = json_decode($_POST['earnPay'], true);
                $personM->setYearEarnPay( $data);
            }



            $personM->setIdPerson($seqPerson);
            if (isset($_POST['coop'])) {
                $personM->setCoop($_POST['coop']);
              }



            if (isset($_POST['argpre'])) {
                $personM->setPrefix_idPrefix($_POST['argpre']);
              }
            if (isset($_POST['fname'])) {
                $personM->setFirstName($_POST['fname']);
            }
            if (isset($_POST['lname'])) {
                $personM->setLastName($_POST['lname']);
            }
            if (isset($_POST['argprovince'])) {
                $personM->setProvince_idProvince($_POST['argprovince']);
            }

            if (isset($_POST['argid'])) {
                $personM->setIdcard($_POST['argid']);
            }
            if (isset($_POST['argbirth'])) {

                 $date=date_create($_POST['argbirth']);
                 $personM->setBirthday(date_format($date,"Y-m-d H:i:s"));;
            }
            if (isset($_POST['tribes'])) {
                $personM->setTribeName($_POST['tribes']);
            }
            if (isset($_POST['religion'])) {
                $personM->setReligionName($_POST['religion']);
            }

            if (isset($_POST['pos_family'])) {
                $personM->setPosFamily($_POST['pos_family']);
            }
            if (isset($_POST['familyCount'])) {
                $personM->setFamilyCount($_POST['familyCount']);
            }
            if (isset($_POST['argno'])) {
                $personM->setAddress($_POST['argno']);
            }
            if (isset($_POST['road'])) {
                $personM->setRoad($_POST['road']);
            }
            if (isset($_POST['argmoo_no'])) {
                $personM->setMoo($_POST['argmoo_no']);
            }
            if (isset($_POST['argmoo_name'])) {
                $personM->setMooName($_POST['argmoo_name']);
            }
            if (isset($_POST['argsub_moo'])) {
                $personM->setSubMooName($_POST['argsub_moo']);
            }
            if (isset($_POST['argsub'])) {
                $personM->setDistrictName($_POST['argsub']);
            }
            if (isset($_POST['argdist'])) {
                $personM->setAmphurIdAmphur($_POST['argdist']);
            }
            if (isset($_POST['argzip_code'])) {
                $personM->setPostcode($_POST['argzip_code']);
            }
            if (isset($_POST['argTel'])) {
                $personM->setPhoneNumber($_POST['argTel']);
            }
            if (isset($_POST['argEmail'])) {
                $personM->setEmail($_POST['argEmail']);
            }
            if (isset($_POST['eduStatus'])) {
                $personM->setEduStatusIdEduStatus($_POST['eduStatus']);
            }
            if (isset($_POST['eduLevel'])) {
                $personM->setEduLevelIdEduLevel($_POST['eduLevel']);
            }
            if (isset($_POST['occupFirst'])) {
                $personM->setOccupFirst($_POST['occupFirst']);
            }
            if (isset($_POST['occupSecond'])) {
                $personM->setOccupSecond($_POST['occupSecond']);
            }
            if (isset($_POST['earnPerYear'])) {
                $personM->setEarnPerYear($_POST['earnPerYear']);
            }
            if (isset($_POST['payPerYear'])) {
                $personM->setPayPerYear($_POST['payPerYear']);
            }
            if (isset($_POST['idGroupVillage'])) {
                $personM->setIdGroupVillage($_POST['idGroupVillage']);
            }
            if (isset($_POST['idRiverBasin'])) {
                $personM->setRiverBasin_idRiverBasin($_POST['idRiverBasin']);
            }
            if (isset($_POST['plots'])) {
                $personM->setPlots($_POST['plots']);
            }
            if (isset($_POST['rai'])) {
                $personM->setRai($_POST['rai']);
            }
            if (isset($_POST['ngan'])) {
                $personM->setNgan($_POST['ngan']);
            }
            if (isset($_POST['sqaurewa'])) {
                $personM->setSqaureWa($_POST['sqaurewa']);
            }
            if (isset($_POST['statusPerson'])) {
                $personM->setStatusPerson($_POST['statusPerson']);
            }


            $pathImage='../img/Activity/';

            if (isset($_POST['image']) && isset($_POST['image'])!==1) {
                $image_parts = explode(";base64,", $_POST['image']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $file =    $pathImage . $seqPerson . '.jpg';
                file_put_contents($file, $image_base64);
                $personM->setPicName($seqPerson . '.jpg');
            }

            if(isset($_FILES["fileToUpload"]["type"]))
            {
                $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                $newfilename = $seqPerson.'.'.end($temp);
               move_uploaded_file($_FILES['fileToUpload']['tmp_name'],  $pathImage.  $newfilename);
                $personM->setPicName($newfilename);
            }

           $personService = new PersonService();
           $personService->addPerson($personM);


        }
        if($action=='update'){
            $personM = new PersonM();

            if (isset($_POST['coop'])) {
                $personM->setCoop($_POST['coop']);
              }

            if (isset($_POST['earnPay'])) {
                $data = json_decode($_POST['earnPay'], true);
                $personM->setYearEarnPay($data);
            }
            if (isset($_POST['agriList'])) {
                $agriList=$_POST['agriList'] ;
                $personM->setAgriList($agriList);
            }


            if (isset($_POST['idPerson'])) {
                $personM->setIdPerson($_POST['idPerson']);
              }
            if (isset($_POST['argpre'])) {
                $personM->setPrefix_idPrefix($_POST['argpre']);
              }
            if (isset($_POST['fname'])) {
                $personM->setFirstName($_POST['fname']);
            }
            if (isset($_POST['lname'])) {
                $personM->setLastName($_POST['lname']);
            }
            if (isset($_POST['argprovince'])) {
                $personM->setProvince_idProvince($_POST['argprovince']);
            }
            if (isset($_POST['area'])) {
                $personM->setArea_idArea($_POST['area']);
            }
            if (isset($_POST['argid'])) {
                $personM->setIdcard($_POST['argid']);
            }


        if (isset($_POST['argbirth'])) {

             $date=date_create($_POST['argbirth']);
             $personM->setBirthday(date_format($date,"Y-m-d H:i:s"));;
        }



            if (isset($_POST['tribes'])) {
                $personM->setTribeName($_POST['tribes']);
            }
            if (isset($_POST['religion'])) {
                $personM->setReligionName($_POST['religion']);
            }
            if (isset($_POST['pos_family'])) {
                $personM->setPosFamily($_POST['pos_family']);
            }
            if (isset($_POST['familyCount'])) {
                $personM->setFamilyCount($_POST['familyCount']);
            }
            if (isset($_POST['argno'])) {
                $personM->setAddress($_POST['argno']);
            }
            if (isset($_POST['road'])) {
                $personM->setRoad($_POST['road']);
            }
            if (isset($_POST['argmoo_no'])) {
                $personM->setMoo($_POST['argmoo_no']);
            }
            if (isset($_POST['argmoo_name'])) {
                $personM->setMooName($_POST['argmoo_name']);
            }
            if (isset($_POST['argsub_moo'])) {
                $personM->setSubMooName($_POST['argsub_moo']);
            }
            if (isset($_POST['argsub'])) {
                $personM->setDistrictName($_POST['argsub']);
            }
            if (isset($_POST['argdist'])) {
                $personM->setAmphurIdAmphur($_POST['argdist']);
            }
            if (isset($_POST['argzip_code'])) {
                $personM->setPostcode($_POST['argzip_code']);
            }
            if (isset($_POST['argTel'])) {
                $personM->setPhoneNumber($_POST['argTel']);
            }
            if (isset($_POST['argEmail'])) {
                $personM->setEmail($_POST['argEmail']);
            }
            if (isset($_POST['eduStatus'])) {
                $personM->setEduStatusIdEduStatus($_POST['eduStatus']);
            }
            if (isset($_POST['eduLevel'])) {
                $personM->setEduLevelIdEduLevel($_POST['eduLevel']);
            }
            if (isset($_POST['occupFirst'])) {
                $personM->setOccupFirst($_POST['occupFirst']);
            }
            if (isset($_POST['occupSecond'])) {
                $personM->setOccupSecond($_POST['occupSecond']);
            }
            if (isset($_POST['earnPerYear'])) {
                $personM->setEarnPerYear($_POST['earnPerYear']);
            }
            if (isset($_POST['payPerYear'])) {
                $personM->setPayPerYear($_POST['payPerYear']);
            }
            if (isset($_POST['idGroupVillage'])) {
                $personM->setIdGroupVillage($_POST['idGroupVillage']);
            }
            if (isset($_POST['idRiverBasin'])) {
                $personM->setRiverBasin_idRiverBasin($_POST['idRiverBasin']);
            }
            if (isset($_POST['plots'])) {
                $personM->setPlots($_POST['plots']);
            }
            if (isset($_POST['rai'])) {
                $personM->setRai($_POST['rai']);
            }
            if (isset($_POST['ngan'])) {
                $personM->setNgan($_POST['ngan']);
            }
            if (isset($_POST['sqaurewa'])) {
                $personM->setSqaureWa($_POST['sqaurewa']);
            }
            if (isset($_POST['path'])) {
                $personM->setPicName($_POST['path']);
            }
            if (isset($_POST['statusPerson'])) {
                $personM->setStatusPerson($_POST['statusPerson']);
            }

            $pathImage='../img/Activity/';
                if (isset($_POST['image']) && isset($_POST['image'])!==1 && strpos($_POST['image'],';base64,') >0) {
                        echo 'toEdit';
                        $image_parts = explode(";base64,", $_POST['image']);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
                        $image_base64 = base64_decode($image_parts[1]);
                        $file =    $pathImage . $personM->getIdPerson() . '.jpg';
                        file_put_contents($file, $image_base64);
                        $personM->setPicName($personM->getIdPerson() . '.jpg');



                }






                if(isset($_FILES["fileToUpload"]["type"]))
                {

                    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                    $newfilename =  $personM->getIdPerson().'.'.end($temp);
                    move_uploaded_file($_FILES['fileToUpload']['tmp_name'],  $pathImage.  $newfilename);
                    $personM->setPicName($newfilename);
                }

               $personService = new PersonService();
               $personService->updatePerson($personM);
        }


        if($action=='delete'){
            if (isset($_POST['person_id'])) {
                $person_id = $_POST['person_id'];
                $personService = new PersonService();
                $personService->delPerson($person_id);
              }
        }

        if($action=='load'){
            if (isset($_POST['person_id'])) {
                $person_id = (int)$_POST['person_id'];

                $personService = new PersonService();
                $personService->loadPersonById($person_id)  ;
              }
        }
        if($action=='isMember'){

            if (isset($_POST['person_ids'])) {
                $person_id[] = $_POST['person_ids'];
                $val = $_POST['val'];

                $personService = new PersonService();
                $personService->updatePersonMember($person_id,$val);

              }

        }

        if($action=='isGroup'){

            if (isset($_POST['person_ids'])) {
                $person_id[] = $_POST['person_ids'];
                $val = $_POST['val'];

                $personService = new PersonService();
                $personService->updatePersonGroup($person_id,$val);

              }

        }



    }

}




?>
