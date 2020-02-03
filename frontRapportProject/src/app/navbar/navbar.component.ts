import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  isauth: Boolean;
  constructor() {this.isAuth()}

  ngOnInit() {
  }

  isAuth() {
    fetch('http://localhost:8000/isAuth', { method: 'GET', mode: 'cors' })
      .then(res => res.json())
      .then(value => {this.isauth = value; console.log(this.isauth)});
  }
  logout(){
    fetch('http://localhost:8000/deconnect',{ method: 'GET', mode: 'cors' }).then(res=>this.isauth=null);
  }
}
