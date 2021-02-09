import 'dart:async';
import 'dart:convert';

import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;

Future<List<Point>> fetchPoints(http.Client client, int idZone) async {
  final response = await client.get(
      'https://projet-tutore-ciasie.herokuapp.com/api/points/zone/' +
          idZone.toString());

  // Use the compute function to run parsePoints in a separate isolate.
  return compute(parsePoints, response.body);
}

// A function that converts a response body into a List<Point>.
List<Point> parsePoints(String responseBody) {
  final parsed = jsonDecode(responseBody).cast<Map<String, dynamic>>();

  return parsed.map<Point>((json) => Point.fromJson(json)).toList();
}

class Point {
  final int idPoint;
  final int idZone;
  final double lat;
  final double lon;

  Point({this.idPoint, this.idZone, this.lat, this.lon});

  factory Point.fromJson(Map<String, dynamic> json) {
    return Point(
      idPoint: json['id_point'] as int,
      idZone: json['id_zone'] as int,
      lat: json['x'] as double,
      lon: json['y'] as double,
    );
  }
}
