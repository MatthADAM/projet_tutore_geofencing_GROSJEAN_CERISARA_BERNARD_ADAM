import 'package:app_geofencing/pages/DetailsPage.dart';
import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import "package:latlong/latlong.dart";
import 'package:location/location.dart';
import 'dart:async';
import 'package:http/http.dart' as http;
import 'package:flutter/cupertino.dart';
import 'package:locally/locally.dart';

import '../models/Point.dart';
import '../models/Zone.dart';
import './DetailsPage.dart';
import '../models/Informations.dart';

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
  bool estDansZone = false;
  int indexCurrentZone;
  bool check = false;
  List<LatLng> pointsCurrentZone = [];
  List<String> nomZone = [];
  List<Informations> listInfos = [];
  List<int> listIds = [];
  int zoneId;
  String zoneInfos;

  Locally locally;

  @override
  void initState() {
    super.initState();

    fetchZones(http.Client()).then(
      (lZone) => {
        lZone.forEach(
          (zoneApi) {
            listeZone.add(zoneApi);
          },
        ),
        listeZone.forEach(
          (zoneFE) {
            fetchPoints(http.Client(), zoneFE.id).then(
              (lPoint) => {
                pts = [],
                lPoint.forEach(
                  (pointFE) {
                    pts.add(LatLng(pointFE.lat, pointFE.lon));
                  },
                ),
                nomZone.add(zoneFE.name),
                res.add(new Polygon(points: pts)),
                listIds.add(zoneFE.id),
              },
            );
          },
        ),
      },
    );
  }

  bool _checkIfValidMarker(LatLng tap, List<LatLng> vertices) {
    int intersectCount = 0;
    for (int j = 0; j < vertices.length - 1; j++) {
      if (rayCastIntersect(tap, vertices[j], vertices[j + 1])) {
        intersectCount++;
      }
    }

    return ((intersectCount % 2) == 1);
  }

  bool rayCastIntersect(LatLng tap, LatLng vertA, LatLng vertB) {
    double aY = vertA.latitude;
    double bY = vertB.latitude;
    double aX = vertA.longitude;
    double bX = vertB.longitude;
    double pY = tap.latitude;
    double pX = tap.longitude;

    if ((aY > pY && bY > pY) || (aY < pY && bY < pY) || (aX < pX && bX < pX)) {
      return false;
    }

    double m = (aY - bY) / (aX - bX);
    double bee = (-aX) * m + aY;
    double x = (pY - bee) / m;

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

        int i = 0;

        res.forEach((e) {
          if (indexCurrentZone == null) {
            indexCurrentZone = i;
          }

          if (i == res.length) {
            i = 0;
          }

          if (!_checkIfValidMarker(
              LatLng(_location.latitude, _location.longitude),
              res[indexCurrentZone].points)) {
            check = _checkIfValidMarker(
                LatLng(_location.latitude, _location.longitude), res[i].points);
          } else {
            check = _checkIfValidMarker(
                LatLng(_location.latitude, _location.longitude),
                res[indexCurrentZone].points);
          }

          if (check && !estDansZone) {
            listInfos = [];
            zoneId = listIds[i];

            // fetchInfos(http.Client(), zoneId).then((infos) => {
            //       listInfos = infos,
            //       print(
            //           "eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee"),
            //     });

            // if (listInfos.length > 0 && !estDansZone) {
            print("  ");
            print("  ");
            // print(listInfos[0].contenu);
            // listInfos.forEach((element) {
            //   print(element.contenu);
            // });
            print("  ");
            print("  ");
            print("VOUS ETES DANS UNE ZONE");
            print("  ");
            print("  ");
            estDansZone = true;
            pointsCurrentZone = res[i].points;
            indexCurrentZone = i;
            print("NOM ZONE ACTUELLE" + nomZone[indexCurrentZone]);

            locally = Locally(
              context: context,
              payload: 'test',
              pageRoute: MaterialPageRoute(
                  builder: (context) =>
                      DetailsPage(text: nomZone[indexCurrentZone])),
              appIcon: 'mipmap/ic_launcher',
            );

            locally.show(
                title: "Changement de zone",
                message: "Entrée dans " + nomZone[indexCurrentZone]);
            // }
          }

          if (!check && estDansZone) {
            print("  ");
            print(check);
            print("  ");
            print("  ");
            print("VOUS N'ETES PAS DANS UNE ZONE");
            print("  ");
            print("  ");
            estDansZone = false;
            pointsCurrentZone = [];
          }
          i++;
        });
      });
    });
  }

  Future<void> stopListen() async {
    _locationSubscription.cancel();
  }

  @override
  Widget build(BuildContext context) {
    _listenLocation();
    if (res.length > 0) {
      return SizedBox(
        height: MediaQuery.of(context).size.height * 0.87,
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
            PolygonLayerOptions(
              polygons: res,
            ),
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
          ],
        ),
      );
    }

    // return CircularProgressIndicator();
    return Center(
      child: Container(
        child: Column(
          children: <Widget>[
            Image(
              image: AssetImage('assets/images/loader.gif'),
              width: 70,
              height: 70,
              color: Colors.white,
            ),
            Text(
              "Carte en cours de chargement",
              style: TextStyle(
                  color: Colors.white, fontFamily: 'Minecraft', fontSize: 15),
            ),
          ],
        ),
      ),
    );
  }
}
