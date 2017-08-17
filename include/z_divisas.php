<?php
/*				  
	AUTO-TRADING-BOT						Copyright (C) 2017
	----------------						John F. Arroyave Gutiérrez
	                					  	unix4you2@gmail.com
	                					  	www.practico.org

    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,MA 02110-1301,USA.
*/

//Si no recibe la moneda a operar pregunta por ella
if (@$argv[1]=="")
	{
		ColorTextoConsola("blue");
		echo "MONEDAS CON CONFIGURACIONES DISPONIBLES:\n\r   BCN = ByteCoin\n\r   ETH = Ethereum\n\r   XMR = Monero\n\r   LTC = LiteCoin\n\r   SC = SiaCoin\n\r";
		ColorTextoConsola("green");
		$MonedaSeleccionadaOperacion = readline("Indique su eleccion: ");
		echo 'Seleccionando configuraciones para: '.$MonedaSeleccionadaOperacion;
		ColorTextoConsola();
	}
else
	$MonedaSeleccionadaOperacion=$argv[1];

//DEFINICIONES DE LA OPERACION
//Configuraciones generales del Bot
$MonedaValida=0;									//Asume que se debe ingresar una moneda para operar

if ($MonedaSeleccionadaOperacion=="BCN")
	{
		$MonedaValida=1;
		$MonedaOperar="BCN";								//Codigo de la moneda que se desea operar
		$DivisaComparadoraMercado="BCNBTC";  				//Codigo de moneda mediante el cual se encuentra su comparacion frente a otra divisa
		$DivisaDeSoporte="BTC";  							//Codigo de la moneda principal utilizada para comprar mas divisas de la moneda a operar 
		$DecimalesPrecision=10;								//Cantidad de decimales utilizada para la precision de la moneda a comerciar
		$SensibilidadMercado=".000000003";  				//Indica el valor sensible que debe ser superado por la diferencia entre el precio de venta y de compra actual de la moneda para lanzar una operacion
		$CambioOfertaMercado=".0000000001";					//Valor utilizado para sumar o restar a los precios de compra y venta actuales y cambiar asi la oferta y demanda del mercado con cada orden nueva
		$ComisionOperador="0.1";  							//En porcentaje (Ej: 0.1 = 0.1%) indica la comision que sera descontada por el operador cuando se llene la orden
		$SaldoMinimoSoporte="0.0002";						//Saldo minimo que se debe tener en la divisa de soporte para comprar mas divisas de las que se desea operar
		$SaldoResidualSoporte=".0001";						//Si despues de realizar una operacion de trading se obtiene este excedente residual lo transfiere a la cuenta principal para asegurarlo
		$TamanoBloqueTrading="3";							//Cantidad de bloques de divisas a negociar por cada interaccion.  Es un multiplicador con $SaldoMinimoTrading.  
															//Ej:  Para realizar una operacion de venta de un bloque (1) BCN se requieren minimo (100) BCN.  Es el bloque minimo a negociar
															//	   Si se va entonces a negociar bloques de 2 entonces se debe subir a 200 el $SaldoMinimoTrading
		$SaldoMinimoTrading=$TamanoBloqueTrading*100;		//Cantidad minima que se debe tener de la divisa a negociar para poder solicitar una venta de esta.  ESTA FORMULA PODRIA CAMBIAR POR CADA DIVISA!!!
		$CantMovimientosTendenciaEstable=5;					//Para motor de inferencia basado en tendencia (a la alza o baja) determina cuantos movimientos del mismo tipo son considerados para establecer una tendencia de moneda 
	}

if ($MonedaSeleccionadaOperacion=="ETH")
	{
		$MonedaValida=1;
		$MonedaOperar="ETH";
		$DivisaComparadoraMercado="ETHBTC";
		$DivisaDeSoporte="BTC";
		$DecimalesPrecision=6;
		$SensibilidadMercado=".000001";
		$CambioOfertaMercado=".0001";
		$ComisionOperador="0.1";
		$SaldoMinimoSoporte="0.0001";
		$SaldoResidualSoporte=".00001";
		$TamanoBloqueTrading="0.1";										
		$SaldoMinimoTrading=$TamanoBloqueTrading*1;
		$CantMovimientosTendenciaEstable=5;
	}

if ($MonedaValida==0)
	{
		echo "Moneda incorrecta o no seleccionada";
		die();
	}