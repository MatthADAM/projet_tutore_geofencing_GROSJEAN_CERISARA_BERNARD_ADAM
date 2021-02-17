import 'dart:async';
import 'dart:convert';

import 'package:http/http.dart' as http;

String uriHeroku = 'https://projet-tutore-ciasie.herokuapp.com/api/infos/zone/';
String uriDocker = 'http://localhost:8001/api/infos/zone/';
String uriIp = 'http://projet-tutore-ciasie.herokuapp.com/api/infos/zone/';

Future<List<Informations>> fetchInfos(http.Client client, int idZone) async {
  final response = await client.get(uriDocker + idZone.toString());

  var obj = jsonDecode(response.body);
  List<Informations> lP = [];

  for (var item in obj['data']) {
    lP.add(new Informations(
        item['id_infos'], item['id_zone'], item['type'], item['contenu']));
  }

  return lP;
}

class Informations {
  final int id_infos;
  final int id_zone;
  final String type;
  final String contenu;

  Informations(this.id_infos, this.id_zone, this.type, this.contenu);
}
