import 'package:flutter/material.dart';
import './MainPage.dart';

class HomePage extends StatefulWidget {
  HomePage({Key key}) : super(key: key);

  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text(
              "Geofencing",
              style: TextStyle(fontFamily: 'Minecraft', fontSize: 40),
            )
          ],
        ),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Text(
              "Bienvenue à la mine de Neuves-Maisons",
              style: TextStyle(fontFamily: 'Minecraft'),
            ),
          ],
        ),
      ),
      backgroundColor: Colors.orangeAccent[100],
    );
  }
}
