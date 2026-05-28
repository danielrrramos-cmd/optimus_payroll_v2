import { Component, OnInit, signal } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { NominaService } from '../../../services/nomina.service';
import { EmpleadoService } from '../../../services/empleado.service';
import { Empleado, Nomina } from '../../../models/models';

@Component({
  selector: 'app-generar-nomina',
  standalone: true,
  imports: [FormsModule, RouterLink, CommonModule],
  templateUrl: './generar-nomina.component.html',
  styleUrl: './generar-nomina.component.css'
})
export class GenerarNominaComponent implements OnInit {
  empleado = signal<Empleado | null>(null);
  nominaGenerada = signal<Nomina | null>(null);
  mes = new Date().getMonth() + 1;
  anio = new Date().getFullYear();
  error = '';

  meses = [
    { value: 1, label: 'Enero' }, { value: 2, label: 'Febrero' },
    { value: 3, label: 'Marzo' }, { value: 4, label: 'Abril' },
    { value: 5, label: 'Mayo' }, { value: 6, label: 'Junio' },
    { value: 7, label: 'Julio' }, { value: 8, label: 'Agosto' },
    { value: 9, label: 'Septiembre' }, { value: 10, label: 'Octubre' },
    { value: 11, label: 'Noviembre' }, { value: 12, label: 'Diciembre' }
  ];

  constructor(
    private nominaService: NominaService,
    private empleadoService: EmpleadoService,
    private route: ActivatedRoute,
    private router: Router
  ) {}

  ngOnInit(): void {
    const id = +this.route.snapshot.paramMap.get('empleadoId')!;
    this.empleadoService.getOne(id).subscribe(emp => this.empleado.set(emp));
  }

  onSubmit(): void {
    const emp = this.empleado();
    if (!emp) return;
    this.error = '';

    this.nominaService.generar(emp.id, this.mes, this.anio).subscribe({
      next: (nomina) => this.nominaGenerada.set(nomina),
      error: (err) => this.error = err.error?.error || 'Error al generar la nómina'
    });
  }
}
