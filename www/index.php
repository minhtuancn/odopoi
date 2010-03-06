<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

  <title>Open Data Ottawa Points of Interest</title>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <script type="text/javascript" src="lib/OpenLayers.js"></script>
  <script type="text/javascript" src="lib/MarkerGrid.js"></script>
  <script type="text/javascript" src="lib/MarkerTile.js"></script>

  <script type="text/javascript" src="http://www.openstreetmap.org/openlayers/OpenStreetMap.js"></script>

  <script type="text/javascript">
    // Coordinates for Ottawa, ON
    var lat=45.420833
    var lon=-75.69

    var zoom=13
        
    var map;
    var POI;

    function get_poi_url_sto() {
      return get_poi_url('sto');
    }

    function get_poi_url(poi_type) {
      var zoom = this.map.getZoom();
      var tlLonLat = this.map.getLonLatFromPixel(new OpenLayers.Pixel(1,1)).
            transform(this.map.getProjectionObject(),this.map.displayProjection);
 
      var mapsize = this.map.getSize();
      var brLonLat = this.map.getLonLatFromPixel(new OpenLayers.Pixel(mapsize.w - 1, mapsize.h - 1)).
            transform(this.map.getProjectionObject(),this.map.displayProjection);

      return "./api.php?action=getPOI"
            + "&tllon=" + tlLonLat.lon;
            + "&tllat=" + tlLonLat.lat;
            + "&brlon=" + brLonLat.lon;
            + "&brlat=" + brLonLat.lat;
            + "&zoom=" + zoom;
            + "&type=" + poi_type;
    }

    function init() {

      map = new OpenLayers.Map ("map", {
        controls: [new OpenLayers.Control.Navigation(), new OpenLayers.Control.PanZoomBar()],
        maxExtent: new OpenLayers.Bounds(-20037508.34,-20037508.34,20037508.34,20037508.34),
        maxResolution: 156543.0399,
        numZoomLevels: 19,
        units: 'm',
        projection: new OpenLayers.Projection("EPSG:900913"),
        displayProjection: new OpenLayers.Projection("EPSG:4326")
      } );

      layerMapnik = new OpenLayers.Layer.OSM.Mapnik("Mapnik");

      POI = new OpenLayers.Layer.MarkerGrid( "STO Bus Stops", {type:'txt', getURL: get_poi_url_sto, attribution: "Open Data Ottawa", buffer: 0});
      POI.setIsBaseLayer(false);
      POI.setVisibility(true);

      map.addLayers([layerMapnik, POI]);
      map.addControl(new OpenLayers.Control.LayerSwitcher());

      var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
      map.setCenter(lonLat, zoom);
    }

  </script>
</head>
<body onload="init();">

  <table style="width: 100%; height: 100%" border="0px" cellspacing="0px" cellpadding="0px">
    <tr>
      <th style="width: 100%;">
        Welcome to OpenDataMap.ca<sup>Alpha</sup>!
      </th>
    </tr>
    <tr>
      <td style="width: 100%;">
        <div><p><em>Warning</em>: The points of interest you see on this page are for testing purposes only and may be totally inaccurate. <a href="http://opendataottawa.ca">Help this app get to Beta</a>.</p></div>
      </td>
    </tr>
    <tr>
      <td style="width: 100%; height: 100%">
        <div style="width:100%; height:100%" id="map"></div>
      </td>
    </tr>
    <tr>
      <td style="width: 100%;">
  <div><p><small>The snazzy map you see above is courtesy of <a href="http://openstreetmap.org">OpenStreetMap</a>. OpenStreeMap data is licensed under 
the <a href="http://creativecommons.org/licenses/by-sa/2.0/">Creative Commons Attribution-Share Alike 2.0 Generic License</a>. The 
<a href="http://github.com/tcort/odopoi">code</a> used to generate this page is based on examples available at <a 
href="http://wiki.openstreetmap.org">wiki.OpenStreetMap.org</a> and is licensed under the 
<a href="http://creativecommons.org/licenses/by-sa/2.0/">Creative Commons Attribution-Share Alike 2.0 Generic License</a>.</small></p></div>
      </td>
    </tr>
  </table>

</body>
</html>