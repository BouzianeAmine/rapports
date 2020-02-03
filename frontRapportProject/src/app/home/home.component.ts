import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  constructor() {
    fetch('http://localhost:8000/rapport', { method: 'GET', mode: 'cors' })
      .then(res => res.json())
      .then(value => console.log(value));
  }

  ngOnInit() {
  }

}
