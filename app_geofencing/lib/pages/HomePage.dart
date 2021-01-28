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
          mainAxisAlignment: MainAxisAlignment.start,
          children: [
            Text("⛏"),
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
                "Projet Tutore",
                style: TextStyle(
                    fontFamily: 'Minecraft', fontSize: 30, color: Colors.white),
              ),
              Text(
                "Geofencing",
                style: TextStyle(
                    fontFamily: 'Minecraft', fontSize: 30, color: Colors.white),
              ),
              Text(
                "Bienvenue à la mine de Neuves-Maisons",
                style: TextStyle(fontFamily: 'Minecraft', color: Colors.white),
              ),
              ElevatedButton(
                child: Text('Entrer'),
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => MainPage()),
                  );
                },
              ),
            ],
          ),
        ),
      ),
    );
  }
}
