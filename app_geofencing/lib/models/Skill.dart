class Skill {
  String kind;
  int value; //min = 0 / max = 5

  String get getKind => kind;
  set setKind(String kind) => this.kind = kind;

  int get getValue => value;
  set setValue(int value) => this.value = value;
}
