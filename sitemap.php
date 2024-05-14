<?php
include ("manteniment/config.php");
include ("manteniment/funciones.php");
$mysqli=conectar();
header('Content-Type: application/xml; charset=utf-8');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset
      xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
      xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
      xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">
<!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->


<url>
  <loc>https://www.futsal.cat/</loc>
  <lastmod>2018-10-31T14:14:37+00:00</lastmod>
  <priority>1.00</priority>
</url>
<url>
  <loc>https://www.futsal.cat/clubs</loc>
  <lastmod>2018-10-31T13:45:32+00:00</lastmod>
  <priority>0.80</priority>
</url>";
 $res1 = $mysqli->query("
    SELECT id,name from clubs where id in (
select idClub from teams where id in (select idTeam from teams_leagues_per_season where idSeason>9)) order by id desc");
  while ($row = mysqli_fetch_array($res1)) {
	  echo "<url>
  <loc>https://www.futsal.cat/clubs/info/".$row['id']."-".teamUrlFormat($row['name'])."</loc>
  <lastmod>2018-10-31T13:38:42+00:00</lastmod>
  <priority>0.80</priority>
</url>";
  }
  $res1 = $mysqli->query("
    SELECT id,name from teams where id in (
select id from teams where id in (select idTeam from teams_leagues_per_season where idSeason>9)) order by id desc");
  while ($row = mysqli_fetch_array($res1)) {
	  echo "<url>
  <loc>https://www.futsal.cat/clubs/equip/".$row['id']."-".teamUrlFormat($row['name'])."</loc>
  <lastmod>2018-10-31T13:38:42+00:00</lastmod>
  <priority>0.80</priority>
</url>";
  }
echo "<url>
  <loc>https://www.futsal.cat/competicio</loc>
  <lastmod>2018-10-31T13:38:42+00:00</lastmod>
  <priority>0.80</priority>
</url>";
$res1 = $mysqli->query("
    SELECT id,name from leagues where idSeason=10 and hide=0 order by id desc");
  while ($row = mysqli_fetch_array($res1)) {
	  $row['name']=str_replace("->","",$row['name']);
	  echo "<url>
  <loc>https://www.futsal.cat/competicio/lliga/".$row['id']."-".teamUrlFormat($row['name'])."</loc>
  <lastmod>2018-10-31T13:38:42+00:00</lastmod>
  <priority>0.80</priority>
</url>";
  }
echo "
<url>
  <loc>https://www.futsal.cat/noticies</loc>
  <lastmod>2018-10-31T13:51:35+00:00</lastmod>
  <priority>0.80</priority>
</url>";
$res1 = $mysqli->query("
    SELECT id,title,insertdate  from news order by id desc limit 0,30");
  while ($row = mysqli_fetch_array($res1)) {
	  echo "<url>
  <loc>https://www.futsal.cat/noticies/detall/".$row['id']."-".teamUrlFormat($row['title'])."</loc>
  <lastmod>".date("r", strtotime($row['insertdate']))."</lastmod>
  <priority>0.80</priority>
</url>";
  }
  echo "
<url>
  <loc>https://www.futsal.cat/documentacio</loc>
  <lastmod>2018-10-31T13:51:36+00:00</lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.futsal.cat/documentacio/sancions</loc>
  <lastmod>2018-10-31T13:51:36+00:00</lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.futsal.cat/multimedia</loc>
  <lastmod>2018-10-31T13:51:36+00:00</lastmod>
  <priority>0.80</priority>
</url>
</urlset>";
?>