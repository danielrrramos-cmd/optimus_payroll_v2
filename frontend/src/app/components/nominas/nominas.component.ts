import { Component, OnInit, signal } from '@angular/core';
import { RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { NominaService } from '../../services/nomina.service';
import { Nomina } from '../../models/models';

@Component({
  selector: 'app-nominas',
  standalone: true,
  imports: [RouterLink, CommonModule],
  templateUrl: './nominas.component.html',
  styleUrl: './nominas.component.css'
})
export class NominasComponent implements OnInit {
  nominas = signal<Nomina[]>([]);

  constructor(private nominaService: NominaService) {}

  ngOnInit(): void {
    this.nominaService.getAll().subscribe(data => this.nominas.set(data));
  }
}
