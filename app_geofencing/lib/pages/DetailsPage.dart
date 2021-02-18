import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

import '../models/Informations.dart';

class DetailsPage extends StatefulWidget {
  String text;
  List<Informations> infos;
  DetailsPage({Key key, @required this.text, @required this.infos})
      : super(key: key);
  @override
  _DetailsPageState createState() => _DetailsPageState();
}

class _DetailsPageState extends State<DetailsPage> {
  List<Widget> l;

  @override
  Widget build(BuildContext context) {
    l.add(
      Text(
        "Nom de la zone : " + widget.text,
        style: TextStyle(color: Colors.white, fontFamily: 'Minecraft'),
      ),
    );
    widget.infos.forEach((element) {
      l.add(
        Text(
          "Infos de la zone : " + element.contenu,
          style: TextStyle(color: Colors.white, fontFamily: 'Minecraft'),
        ),
      );
    });
    return Scaffold(
      appBar: AppBar(
        title: Row(
          mainAxisAlignment: MainAxisAlignment.start,
          children: [
            Text("⛏ - Details"),
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
            children: l,
          ),
        ),
      ),
    );
  }
}
