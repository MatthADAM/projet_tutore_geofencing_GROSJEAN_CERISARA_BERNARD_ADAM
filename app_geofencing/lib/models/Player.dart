import './Team.dart';

class Player {
  String uuid;
  String firstname;
  String lastname;
  String email;
  int gender; //1 = male 2 = female
  Team team;

  String get getUuid => this.uuid;
  set setUuid(String uuid) => this.uuid = uuid;

  String get getFirstname => this.firstname;
  set setFirstname(String firstname) => this.firstname = firstname;

  String get getLastname => this.lastname;
  set setLastname(String lastname) => this.lastname = lastname;

  String get getEmail => this.email;
  set setEmail(String email) => this.email = email;

  int get getGender => this.gender;
  set setGender(int gender) => this.gender = gender;

  Team get getTeam => this.team;
  set setTeam(Team team) => this.team = team;
}
