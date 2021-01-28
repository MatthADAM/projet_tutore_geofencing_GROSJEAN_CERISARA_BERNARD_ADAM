import './Skill.dart';

class Character {
  String uuid;
  String name;
  Skill strength;
  Skill cleverness;
  Skill intelligence;
  Skill speed;
  String image;

  String get getUuid => this.uuid;
  set setUuid(String uuid) => this.uuid = uuid;

  String get getName => this.name;
  set setName(String uuid) => this.uuid = uuid;

  Skill get getStrength => this.strength;
  set setStrength(Skill str) => this.strength = str;

  Skill get getCleverness => this.cleverness;
  set setCleverness(Skill cleverness) => this.cleverness = cleverness;

  Skill get getIntelligence => this.intelligence;
  set setIntelligence(Skill intelligence) => this.intelligence = intelligence;

  Skill get getSpeed => this.speed;
  set setSpeed(Skill speed) => this.speed = speed;

  String get getImage => image;
  set setImage(String image) => this.image = image;
}
