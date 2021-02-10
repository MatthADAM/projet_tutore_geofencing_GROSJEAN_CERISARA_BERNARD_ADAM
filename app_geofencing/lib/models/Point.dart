import 'dart:async';
import 'dart:convert';

import 'package:http/http.dart' as http;

Future<List<Point>> fetchPoints(http.Client client, int idZone) async {
  final response = await client.get(
      'https://projet-tutore-ciasie.herokuapp.com/api/points/zone/' +
          idZone.toString());

  var obj = jsonDecode(response.body);
  List<Point> lP = [];
  for (var item in obj['data']) {
    lP.add(new Point(item['id_point'], item['id_zone'], item['x'], item['y']));
  }
  return lP;
}

class Point {
  final int idPoint;
  final int idZone;
  final double lat;
  final double lon;

  Point(this.idPoint, this.idZone, this.lat, this.lon);
}
