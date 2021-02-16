import 'dart:async';
import 'dart:convert';

import 'package:http/http.dart' as http;

Future<List<Informations>> fetchInfos(http.Client client, int idZone) async {
  final response = await client.get(
      'https://projet-tutore-ciasie.herokuapp.com/api/infos/zone/' +
          idZone.toString());

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
