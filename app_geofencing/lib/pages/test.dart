import 'package:flutter/material.dart';
import 'package:location/location.dart';

class test extends StatefulWidget {
  @override
  _testState createState() => _testState();
}

class _testState extends State<test> {
  Future<LocationData> currentLocation;
  Location location;
  Center test;

  @override
  void initState() {
    super.initState();

    location = new Location();
    currentLocation = location.getLocation();
  }

  @override
  Widget build(BuildContext context) {
    return SizedBox(
        height: 100,
        child: FutureBuilder(
            future: currentLocation,
            builder:
                (BuildContext context, AsyncSnapshot<LocationData> snapshot) {
              switch (snapshot.connectionState) {
                case ConnectionState.waiting:
                  return new Center(child: new CircularProgressIndicator());
                case ConnectionState.done:
                  if (snapshot.hasError) {
                    test = Center(
                      child: Text(
                        '${snapshot.error}',
                        style: TextStyle(color: Colors.red),
                      ),
                    );
                  } else {
                    test = Center(
                      child: Text(
                        snapshot.data.latitude.toString() +
                            " - " +
                            snapshot.data.longitude.toString(),
                        style: TextStyle(color: Colors.white),
                      ),
                    );
                  }
                  return test;
                default:
                  return new Text('');
              }
            }));
  }
}
