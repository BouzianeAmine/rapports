import { Component, OnInit } from '@angular/core';
import { MatTableDataSource } from '@angular/material/table';
import { Rapport } from '../models/rapport';



@Component({
  selector: 'app-rapports',
  templateUrl: './rapports.component.html',
  styleUrls: ['./rapports.component.css']
})
export class RapportsComponent implements OnInit {
  displayedColumns: string[] = ['name', 'filiere', 'sujet','data'];
  dataSource: MatTableDataSource<Rapport>;
  fileBlob: Blob;
  rapports: Array<Rapport>;
  constructor() {
    this.getRapports();
  }

  ngOnInit() {}

  getRapports() {
    fetch('http://localhost:8000/bootstrap.php/rapports', { method: 'GET', mode: 'cors' }).then(res => res.json()).then((rapports: Array<Rapport>) => { this.dataSource = new MatTableDataSource(rapports); });
  }

  applyFilter(filterValue: string) {
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }
}
