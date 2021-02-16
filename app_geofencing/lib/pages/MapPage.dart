import 'package:app_geofencing/pages/DetailsPage.dart';
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
import './DetailsPage.dart';

class MapPage extends StatefulWidget {
  @override
  _MapPageState createState() => _MapPageState();
  void _showNotification() {
    _MapPageState()._showNotification();
  }
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
            // _showNotification();
            showDialog(
              context: context,
              builder: (BuildContext context) => CupertinoAlertDialog(
                title: Text("Test"),
                content: Text(
                    "Vous entrez dans la zone " + nomZone[indexCurrentZone]),
                actions: <Widget>[
                  CupertinoDialogAction(
                    isDefaultAction: true,
                    child: Text('Ok'),
                    onPressed: () async {
                      Navigator.of(context, rootNavigator: true).pop();
                    },
                  ),
                  CupertinoDialogAction(
                    isDefaultAction: false,
                    child: Text('Infos zone'),
                    onPressed: () {
                      Navigator.of(context, rootNavigator: true).pop();
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => DetailsPage(
                            text: nomZone[indexCurrentZone],
                          ),
                        ),
                      );
                    },
                  ),
                ],
              ),
            );
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
            /* _showNotification();
            showDialog(
              context: context,
              builder: (BuildContext context) => CupertinoAlertDialog(
                title: Text("Test"),
                content:
                    Text("Vous sortez de la zone " + nomZone[indexCurrentZone]),
                actions: <Widget>[
                  CupertinoDialogAction(
                    isDefaultAction: true,
                    child: Text('Ok'),
                    onPressed: () async {
                      Navigator.of(context, rootNavigator: true).pop();
                    },
                  )
                ],
              ),
            ); */
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

  Future onSelectNotification(String payload) async {
    if (payload != null) {
      debugPrint('Notification payload: $payload');
    }
    await print('clicked');
  }

  Future onDidReceiveLocalNotification(
      int id, String title, String body, String payload) async {
    await showDialog(
        context: context,
        builder: (BuildContext context) => CupertinoAlertDialog(
              title: Text(title),
              content: Text(body),
              actions: <Widget>[
                CupertinoDialogAction(
                  isDefaultAction: true,
                  child: Text('Ok'),
                  onPressed: () async {
                    Navigator.of(context, rootNavigator: true).pop();
                  },
                )
              ],
            ));
  }

  @override
  void initState() {
    super.initState();

    const AndroidInitializationSettings initializationSettingsAndroid =
        AndroidInitializationSettings("@mipmap/ic_launcher");
    final IOSInitializationSettings initializationSettingsIOS =
        IOSInitializationSettings(
            onDidReceiveLocalNotification: onDidReceiveLocalNotification);
    final InitializationSettings initializationSettings =
        InitializationSettings(
            android: initializationSettingsAndroid,
            iOS: initializationSettingsIOS);
    flutterLocalNotificationsPlugin.initialize(initializationSettings,
        onSelectNotification: onSelectNotification);

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
