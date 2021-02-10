import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import "package:latlong/latlong.dart";
import 'package:location/location.dart';
import 'dart:async';
import 'package:http/http.dart' as http;

import '../models/Point.dart';
import '../models/Zone.dart';

class MapPage extends StatefulWidget {
  @override
  _MapPageState createState() => _MapPageState();
}

class _MapPageState extends State<MapPage> {
  final Location location = Location();

  LocationData _location;
  StreamSubscription<LocationData> _locationSubscription;
  String error;
  List<Zone> listeZone = [];
  List<Point> listePoint = [];
  List<Polygon> res = [];
  List<LatLng> pts = [];

  List<LatLng> points = [
    LatLng(48.6871871948, 5.8719520569),
    LatLng(48.6872024536, 5.8720889091),
    LatLng(48.6870880127, 5.8721261024),
    LatLng(48.687084198, 5.8719787598)
  ];

  List<LatLng> points1 = [
    LatLng(48.6591262817, 6.1935234070),
    LatLng(48.6591491699, 6.1936411858),
    LatLng(48.6590843201, 6.1936759949),
    LatLng(48.6590423584, 6.1935606003)
  ];

  bool _checkIfValidMarker(LatLng tap, List<LatLng> vertices) {
    int intersectCount = 0;
    for (int j = 0; j < vertices.length - 1; j++) {
      if (rayCastIntersect(tap, vertices[j], vertices[j + 1])) {
        intersectCount++;
      }
    }

    return ((intersectCount % 2) == 1); // odd = inside, even = outside;
  }

  bool rayCastIntersect(LatLng tap, LatLng vertA, LatLng vertB) {
    double aY = vertA.latitude;
    double bY = vertB.latitude;
    double aX = vertA.longitude;
    double bX = vertB.longitude;
    double pY = tap.latitude;
    double pX = tap.longitude;

    if ((aY > pY && bY > pY) || (aY < pY && bY < pY) || (aX < pX && bX < pX)) {
      return false; // a and b can't both be above or below pt.y, and a or
      // b must be east of pt.x
    }

    double m = (aY - bY) / (aX - bX); // Rise over run
    double bee = (-aX) * m + aY; // y = mx + b
    double x = (pY - bee) / m; // algebra is neat!

    return x > pX;
  }

  Future<void> _listenLocation() async {
    _locationSubscription =
        location.onLocationChanged.handleError((dynamic err) {
      setState(() {
        error = err.code;
      });
      _locationSubscription.cancel();
    }).listen((LocationData currentLocation) {
      setState(() {
        error = null;

        _location = currentLocation;
      });
    });
  }

  Future<void> stopListen() async {
    _locationSubscription.cancel();
  }

  void createPolygons() {
    listeZone.forEach((element) {
      fetchPoints(http.Client(), element.id)
          .then((value) => listePoint = value);
      listePoint.forEach((element2) {
        pts.add(LatLng(element2.lat, element2.lon));
      });
      res.add(Polygon(points: pts));
    });
  }

  @override
  void initState() {
    super.initState();
    fetchZones(http.Client()).then(
      (value) => {
        value.forEach(
          (element) {
            listeZone.add(element);
          },
        ),
        listeZone.forEach(
          (element) {
            fetchPoints(http.Client(), element.id).then(
              (value) => {
                value.forEach(
                  (element) {
                    listePoint.add(element);
                  },
                ),
                listePoint.forEach(
                  (element2) {
                    pts.add(LatLng(element2.lat, element2.lon));
                  },
                ),
                res.add(Polygon(points: pts)),
                listePoint.clear(),
              },
            );
            listePoint.clear();
          },
        ),
      },
    );
    // createPolygons();

    /* listeZone.forEach(
      (element) {
        fetchPoints(http.Client(), element.id).then(
          (value) => {
            value.forEach(
              (element) {
                listePoint.add(element);
              },
            ),
          },
        );
        listePoint.forEach(
          (element2) {
            pts.add(LatLng(element2.lat, element2.lon));
          },
        );
        res.add(Polygon(points: pts));
      },
    ); */
  }

  @override
  Widget build(BuildContext context) {
    _listenLocation();
    LatLng latlng = LatLng(48.659114, 6.193596);
    if (_checkIfValidMarker(latlng, points1)) {
      print("  ");
      print("  ");
      print("LE POINT EST DANS UN POLYGONE");
      print("  ");
      print("  ");
    } else {
      print("  ");
      print("  ");
      print("LE POINT N'EST PAS DANS UN POLYGONE");
      print("  ");
      print("  ");
    }
    if (res.length > 0) {
      print(res[0].points);
      print("----------1----------");
      print(res[1].points);
      print("----------2----------");
      print(res[2].points);
      print("----------3----------");
      print(res[3].points);
      print("----------4----------");
      return SizedBox(
        height: 400,
        child: new FlutterMap(
          options: new MapOptions(
            center: new LatLng(/* 48.6309538, 6.1067854 */ _location.latitude,
                _location.longitude),
            zoom: 19,
          ),
          layers: [
            new TileLayerOptions(
                urlTemplate:
                    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
                subdomains: ['a', 'b', 'c'],
                maxZoom: 19,
                maxNativeZoom: 19),
            MarkerLayerOptions(
              markers: [
                Marker(
                  width: 20,
                  height: 20,
                  point: LatLng(_location.latitude, _location.longitude),
                  builder: (ctx) => Container(
                    child:
                        Image(image: new AssetImage("assets/images/user.png")),
                  ),
                )
              ],
            ),
            PolygonLayerOptions(
              polygons:
                  /* [
                Polygon(points: points),
                Polygon(points: points1),
              ], */
                  res,
            ),
          ],
        ),
      );
    }

    // return CircularProgressIndicator();
    return Center(
      child: Container(
        child: Column(
          children: <Widget>[
            CircularProgressIndicator(),
            Text(
              "Carte en cours de chargement",
              style: TextStyle(color: Colors.white, fontFamily: 'Minceraft'),
            ),
          ],
        ),
      ),
    );
  }
}
