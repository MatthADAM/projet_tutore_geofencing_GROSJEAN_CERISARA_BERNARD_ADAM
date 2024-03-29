import 'dart:async';
import 'dart:convert';

import 'package:http/http.dart' as http;

String uriHeroku = 'https://projet-tutore-ciasie.herokuapp.com/api/zone';
String uriDocker = 'http://localhost:8001/api/zone';
String uriIp = 'http://projet-tutore-ciasie.herokuapp.com/api/zone';

Future<List<Zone>> fetchZones(http.Client client) async {
  final response = await client.get(uriHeroku);

  var obj = jsonDecode(response.body);
  List<Zone> lZ = [];
  for (var item in obj['data']) {
    lZ.add(new Zone(
        item['id_zone'], item['nom'], item['description'], item['id_user']));
  }
  return lZ;
}

class Zone {
  final int id;
  final String name;
  final String desc;
  final int id_user;

  Zone(this.id, this.name, this.desc, this.id_user);
}
