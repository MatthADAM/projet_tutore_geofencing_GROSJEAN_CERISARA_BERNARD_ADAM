import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import "package:latlong/latlong.dart";
import 'package:location/location.dart';
import 'dart:async';
import 'package:http/http.dart' as http;
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:flutter/cupertino.dart';

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
  bool estDansZone = false;
  int indexCurrentZone;
  bool check = false;
  List<LatLng> pointsCurrentZone = [];
  List<String> nomZone = [];

  FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin =
      new FlutterLocalNotificationsPlugin();
  var initializationSettingsAndroid;
  var initializationSettingsIOS;
  var initializationSettings;

  void _showNotification() async {
    await _demoNotification();
  }

  Future<void> _demoNotification() async {
    var androidPlatformChannelSpecifics = AndroidNotificationDetails(
        'channel_ID', 'channel name', 'channel description',
        importance: Importance.max,
        priority: Priority.high,
        ticker: 'test ticker');

    var iOSChannelSpecifics = IOSNotificationDetails();
    var platformChannelSpecifics = NotificationDetails();

    await flutterLocalNotificationsPlugin.show(0, 'Hello, buddy',
        'A message from flutter buddy', platformChannelSpecifics,
        payload: 'test oayload');
  }

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

        int i = 0;

        res.forEach((e) {
          if (indexCurrentZone == null) {
            indexCurrentZone = i;
          }

          if (i == 4) {
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
            _showNotification();
            print("  ");
            print(check);
            print("  ");
            print("  ");
            print("VOUS ETES DANS UNE ZONE");
            print("  ");
            print("  ");
            estDansZone = true;
            pointsCurrentZone = res[i].points;
            indexCurrentZone = i;
            print("NOM ZONE ACTUELLE" + nomZone[indexCurrentZone]);
          }

          if (!check && estDansZone) {
            _showNotification();
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
  void initState() {
    super.initState();

    //   const AndroidInitializationSettings initializationSettingsAndroid =
    //       AndroidInitializationSettings("@mipmap/ic_launcher");
    //   final IOSInitializationSettings initializationSettingsIOS =
    //       IOSInitializationSettings(
    //           onDidReceiveLocalNotification: onDidReceiveLocalNotification);
    //   final InitializationSettings initializationSettings =
    //       InitializationSettings(
    //           android: initializationSettingsAndroid,
    //           iOS: initializationSettingsIOS);
    //   flutterLocalNotificationsPlugin.initialize(initializationSettings,
    //       onSelectNotification: onSelectNotification);
    // }

    // Future onSelectNotification(String payload) async {
    //   if (payload != null) {
    //     debugPrint('Notification payload: $payload');
    //   }
    //   await print('clicked');
    // }

    // Future onDidReceiveLocalNotification(
    //     int id, String title, String body, String payload) async {
    //   await showDialog(
    //       context: context,
    //       builder: (BuildContext context) => CupertinoAlertDialog(
    //             title: Text(title),
    //             content: Text(body),
    //             actions: <Widget>[
    //               CupertinoDialogAction(
    //                 isDefaultAction: true,
    //                 child: Text('Ok'),
    //                 onPressed: () async {
    //                   Navigator.of(context, rootNavigator: true).pop();
    //                 },
    //               )
    //             ],
    //           ));

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
              },
            );
          },
        ),
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    _listenLocation();
    // LatLng latlng = LatLng(48.659114, 6.193596);
    // if (_checkIfValidMarker(latlng, points1)) {
    //   print("  ");
    //   print("  ");
    //   print("LE POINT EST DANS UN POLYGONE");
    //   print("  ");
    //   print("  ");
    // } else {
    //   print("  ");
    //   print("  ");
    //   print("LE POINT N'EST PAS DANS UN POLYGONE");
    //   print("  ");
    //   print("  ");
    // }
    if (res.length > 0) {
      return SizedBox(
        height: 500,
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
              polygons:
                  /* [
                Polygon(points: points),
                Polygon(points: points1),
              ], */
                  res,
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
