import { Component, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { EmpleadoService } from '../../services/empleado.service';
import { Empleado } from '../../models/models';

@Component({
  selector: 'app-empleados',
  standalone: true,
  imports: [RouterLink, CommonModule],
  templateUrl: './empleados.component.html',
  styleUrl: './empleados.component.css'
})
export class EmpleadosComponent implements OnInit {
  empleados: Empleado[] = [];

  constructor(private empleadoService: EmpleadoService) {}

  ngOnInit(): void {
    this.loadEmpleados();
  }

  loadEmpleados(): void {
    this.empleadoService.getAll().subscribe(data => this.empleados = data);
  }

  eliminar(id: number): void {
    if (confirm('¿Estás seguro de eliminar este empleado?')) {
      this.empleadoService.delete(id).subscribe(() => this.loadEmpleados());
    }
  }
}
