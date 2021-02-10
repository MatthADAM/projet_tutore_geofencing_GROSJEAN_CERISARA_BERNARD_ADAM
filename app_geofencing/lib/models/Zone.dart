import 'dart:async';
import 'dart:convert';

import 'package:http/http.dart' as http;

Future<List<Zone>> fetchZones(http.Client client) async {
  final response =
      await client.get('https://projet-tutore-ciasie.herokuapp.com/api/zone');

  var obj = jsonDecode(response.body);
  List<Zone> lZ = [];
  for (var item in obj['data']) {
    lZ.add(new Zone(item['id_zone'], item['nom'], item['description']));
  }
  return lZ;
}

class Zone {
  final int id;
  final String name;
  final String desc;

  Zone(this.id, this.name, this.desc);
}
