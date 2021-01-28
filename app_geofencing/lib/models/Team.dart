import './Character.dart';
import './Player.dart';

class Team {
  String uuid;
  Player player;
  List<Character> characters;

  String get getUuid => this.uuid;
  set setUuid(String uuid) => this.uuid = uuid;

  Player get getPlayer => this.player;
  set setPlayer(Player player) => this.player = player;

  List<Character> get getCharacters => this.characters;
  set setCharacters(List<Character> characters) => this.characters = characters;
}
