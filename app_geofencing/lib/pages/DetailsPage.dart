import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class DetailsPage extends StatefulWidget {
  String text;
  DetailsPage({Key key, @required this.text}) : super(key: key);
  @override
  _DetailsPageState createState() => _DetailsPageState();
}

class _DetailsPageState extends State<DetailsPage> {
  @override
  Widget build(BuildContext context) {
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
            children: <Widget>[
              Text(
                "Infos de la zone : " + widget.text,
                style: TextStyle(color: Colors.white, fontFamily: 'Minecraft'),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
