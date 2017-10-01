SELECT *
FROM `cexp_collectionsetup` `colSetup`
INNER JOIN `cexp_services` `srvc` ON `srvc`.`ServiceID`=`colSetup`.`ServiceID`
INNER JOIN `cexp_means` `mns` ON `mns`.`MeansID`=`colSetup`.`MeansID`
INNER JOIN `cexp_pays` `ste1` ON `ste1`.`id`=`colSetup`.`StateOrigineID`
INNER JOIN `cexp_pays` `ste2` ON `ste2`.`id`=`colSetup`.`StateDestinationID`
INNER JOIN `cexp_weightRanges` `wrg` ON `wrg`.`WeightRangesID`=`colSetup`.`WeightRangesID`
INNER JOIN `cexp_volumeRanges` `vrg` ON `vrg`.`VolumeRangeID`=`colSetup`.`VolumeRangesID`
WHERE `colSetup`.`ArticleID` = 1
AND `colSetup`.`MeansID` = '3'
AND `colSetup`.`StateDestinationID` = '94'
AND `colSetup`.`StateOrigineID` = '75'
AND `wrg`.`MinWeight` < '4.5'
AND `wrg`.`MaxWeight` >= '4.5'
AND `vrg`.`MinVolume` < 11.45745
AND `vrg`.`MaxVolume` >= 11.45745
AND `colSetup`.`ServiceID` = '2'

"[{"Designation":"","ArticleID":"2","Weight":0,"lenght":0,"width":0,"height":0,"bntadd":"true","displayed":"none","$$hashKey":"005"},
{"Designation":"","ArticleID":"4","Weight":0,"lenght":0,"width":0,"height":0,"bntadd":"false","$$hashKey":"1L4","displayed":"none"},
{"Designation":"","ArticleID":"5","Weight":0,"lenght":0,"width":0,"height":0,"bntadd":"false","$$hashKey":"1LC","displayed":"none"}]"

SELECT * FROM cexp_collectionsetup colectSetup
INNER JOIN cexp_articles arti ON arti.ArticleID=colectSetup.ArticleID
INNER JOIN cexp_volumeRanges vrg ON vrg.VolumeRangeID=colectSetup.VolumeRangesID
INNER JOIN cexp_weightRanges wrg ON wrg.WeightRangesID=colectSetup.WeightRangesID
WHERE colectSetup.ArticleID=2 
AND  colectSetup.ServiceID=2 
AND  colectSetup.MeansID=3 
AND  colectSetup.StateOrigineID=75 
AND  colectSetup.StateDestinationID=94

SELECT * FROM cexp_collectionsetup colectSetup
INNER JOIN cexp_articles arti ON arti.ArticleID=colectSetup.ArticleID
INNER JOIN cexp_volumeRanges vrg ON vrg.VolumeRangeID=colectSetup.VolumeRangesID
INNER JOIN cexp_weightRanges wrg ON wrg.WeightRangesID=colectSetup.WeightRangesID
WHERE colectSetup.ArticleID=4 
AND  colectSetup.ServiceID=2 
AND  colectSetup.MeansID=3 
AND  colectSetup.StateOrigineID=75 
AND  colectSetup.StateDestinationID=94

 [
  {"Designation":"","ArticleID":"2","Weight":0,"lenght":0,"width":0,"height":0,"bntadd":"true","displayed":"none","$$hashKey":"005"},
  {"Designation":"","ArticleID":"4","Weight":0,"lenght":0,"width":0,"height":0,"bntadd":"false","$$hashKey":"1KW","displayed":"none"},
  {"Designation":"","ArticleID":"5","Weight":0,"lenght":0,"width":0,"height":0,"bntadd":"false","$$hashKey":"1L4","displayed":"none"},
  {"Designation":"Caisse de chocolat","ArticleID":1,"Weight":"4.89","lenght":"2.07","width":"2.70","height":"2.89","bntadd":"false","$$hashKey":"1LC"}
 ]
