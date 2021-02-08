import 'package:flutter/material.dart';
import './MapPage.dart';
import './test.dart';
import './listen_location.dart';

class MainPage extends StatefulWidget {
  @override
  _MainPageState createState() => _MainPageState();
}

class _MainPageState extends State<MainPage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Row(
          mainAxisAlignment: MainAxisAlignment.start,
          children: [
            Text("⛏ - Carte"),
          ],
        ),
      ),
      body: Center(
        child: Container(
          constraints: BoxConstraints.expand(),
          decoration: BoxDecoration(
              image: DecorationImage(
                  image: AssetImage('assets/images/bgMine.jpg'),
                  fit: BoxFit.cover)),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              Text(
                "Page principale",
                style: TextStyle(fontFamily: 'Minecraft', color: Colors.white),
              ),
              MapPage(),
              ListenLocationWidget(),
            ],
          ),
        ),
      ),
    );
  }
}
