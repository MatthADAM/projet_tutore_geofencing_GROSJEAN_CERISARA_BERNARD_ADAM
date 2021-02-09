import 'dart:async';
import 'dart:convert';

import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;

Future<List<Zone>> fetchZones(http.Client client) async {
  final response =
      await client.get('https://projet-tutore-ciasie.herokuapp.com/api/zone');

  // Use the compute function to run parseZones in a separate isolate.
  return compute(parseZones, response.body);
}

// A function that converts a response body into a List<Zone>.
List<Zone> parseZones(String responseBody) {
  final parsed = jsonDecode(responseBody).cast<Map<String, dynamic>>();

  return parsed.map<Zone>((json) => Zone.fromJson(json)).toList();
}

class Zone {
  final int id;
  final String name;
  final String desc;

  Zone({this.id, this.name, this.desc});

  factory Zone.fromJson(Map<String, dynamic> json) {
    return Zone(
      id: json['id_zone'] as int,
      name: json['nom'] as String,
      desc: json['description'] as String,
    );
  }
}
