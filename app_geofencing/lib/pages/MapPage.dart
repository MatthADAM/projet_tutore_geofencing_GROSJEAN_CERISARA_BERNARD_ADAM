import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import "package:latlong/latlong.dart";
import 'package:location/location.dart';
import 'dart:async';

class MapPage extends StatefulWidget {
  @override
  _MapPageState createState() => _MapPageState();
}

class _MapPageState extends State<MapPage> {
  final Location location = Location();

  LocationData _location;
  StreamSubscription<LocationData> _locationSubscription;
  String _error;

  Future<void> _listenLocation() async {
    _locationSubscription =
        location.onLocationChanged.handleError((dynamic err) {
      setState(() {
        _error = err.code;
      });
      _locationSubscription.cancel();
    }).listen((LocationData currentLocation) {
      setState(() {
        _error = null;

        _location = currentLocation;
      });
    });
  }

  Future<void> _stopListen() async {
    _locationSubscription.cancel();
  }

  @override
  Widget build(BuildContext context) {
    _listenLocation();
    return SizedBox(
      height: 400,
      child: new FlutterMap(
        options: new MapOptions(
          center: new LatLng(48.6309538, 6.1067854),
          zoom: 16.0,
        ),
        layers: [
          new TileLayerOptions(
            urlTemplate: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            subdomains: ['a', 'b', 'c'],
          ),
          MarkerLayerOptions(markers: [
            Marker(
              width: 10,
              height: 10,
              point: LatLng(_location.latitude, _location.longitude),
              builder: (ctx) => Container(
                child: FlutterLogo(),
              ),
            )
          ]),
        ],
      ),
    );
  }
}
