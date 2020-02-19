import { Component, OnInit } from '@angular/core';
import { Rapport } from '../models/rapport';
import { FormGroup, Validators, FormBuilder } from '@angular/forms';
import { User } from '../models/user';
import { toJSON, toString, getCurrentUser } from '../handlers/userSession';
import { UserService } from '../user.service';

export interface rapportDetails {
  filiere: string,
  annee: string,
  encadrant: string,
  sujet: string,
  societe: string
}

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  rapports: Array<Rapport>;
  currentUser: User;
  rapport:rapportDetails;
  formData:FormData;
  constructor(private _formBuilder: FormBuilder,private userSP:UserService) {
    getCurrentUser().subscribe(user=>{this.currentUser=user});
    this.rapport={"filiere":"","annee":"","encadrant":"","sujet":"","societe":""}
  }

  ngOnInit() {
    fetch('http://localhost:8000/bootstrap.php/rapport', { method: 'POST', mode: 'cors', body: toString(this.currentUser) })
      .then(res => res.json())
      .then((value: Array<Rapport>) => this.rapports = value);
  }

  handleFileInput(event) {
    this.formData = new FormData();
    this.formData.append('file', event.target.files[0]);
    this.formData.append('user',toString(this.currentUser));
  }

  ajouter(){
    this.formData.append('rapportDetails',toString(this.rapport));
    fetch("http://localhost:8000/uploader.php", { method: 'POST', mode: 'cors', body: this.formData })
    .then(res => {
      if (res.ok) {
        console.log('the file is uploaded')
      }
    })
  }
}
