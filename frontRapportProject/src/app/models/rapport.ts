export class Rapport {
  id: number;
  name: string;
  type: string;
  data: string;
  public email: string;
  constructor(name,type){
    this.name=name;
    this.type=type;
    this.data=null;
  }
  static makeRapportFromFile(file:File){
    return new Rapport(file.name,file.type);
  }
}