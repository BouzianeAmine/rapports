import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  constructor(private httpCall:HttpClient) {
      
  }

  ngOnInit() {
    this.httpCall.get('http://localhost:8000/rapport').subscribe(res=>console.log(res));
  }

}
