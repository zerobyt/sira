<definitions
	xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
	xmlns:xsd="http://www.w3.org/2001/XMLSchema"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
	xmlns:tns="http://service.common.www.ventanillaunica.gob.mx/"
	xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
	xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/"
	xmlns="http://schemas.xmlsoap.org/wsdl/" targetNamespace="{{ $nameSpace }}">
	<types>
		<xsd:schema targetNamespace="{{ $nameSpace }}">
			<xsd:import namespace="http://schemas.xmlsoap.org/soap/encoding/"/>
			<xsd:import namespace="http://schemas.xmlsoap.org/wsdl/"/>
		</xsd:schema>
	</types>
	<message name="notificacionIngresoMercanciaRequest">
		<part name="parameters" type="tns:notificacionIngresoMercancia"/>
	</message>
	<message name="notificacionIngresoMercanciaResponse">
		<part name="response" type="tns:notificacionIngresoMercanciaResponse"/>
	</message>
	<message name="ingresoSinIDRequest">
		<part name="parameters" type="tns:ingresoSinID"/>
	</message>
	<message name="ingresoSinIDResponse">
		<part name="response" type="tns:ingresoSinIDResponse"/>
	</message>
	<message name="ingresoSimpleRequest">
		<part name="parameters" type="tns:ingresoSimple"/>
	</message>
	<message name="ingresoSimpleResponse">
		<part name="response" type="tns:ingresoSimpleResponse"/>
	</message>
	<message name="ingresoParcialRequest">
		<part name="parameters" type="tns:ingresoParcial"/>
	</message>
	<message name="ingresoParcialResponse">
		<part name="response" type="tns:ingresoParcialResponse"/>
	</message>
	<message name="rechazoRequest">
		<part name="parameters" type="tns:rechazo"/>
	</message>
	<message name="rechazoResponse">
		<part name="response" type="tns:rechazoResponse"/>
	</message>
	<message name="ingresoFlujoAlternoRequest">
		<part name="parameters" type="tns:ingresoFlujoAlterno"/>
	</message>
	<message name="ingresoFlujoAlternoResponse">
		<part name="response" type="tns:ingresoFlujoAlternoResponse"/>
	</message>
	<message name="salidaPedimentoRequest">
		<part name="parameters" type="tns:salidaPedimento"/>
	</message>
	<message name="salidaPedimentoResponse">
		<part name="response" type="tns:salidaPedimentoResponse"/>
	</message>
	<message name="desconsolidacionMasterRequest">
		<part name="parameters" type="tns:desconsolidacionMaster"/>
	</message>
	<message name="desconsolidacionMasterResponse">
		<part name="response" type="tns:desconsolidacionMasterResponse"/>
	</message>
	<message name="consolidacionMasterRequest">
		<part name="parameters" type="tns:consolidacionMaster"/>
	</message>
	<message name="consolidacionMasterResponse">
		<part name="response" type="tns:consolidacionMasterResponse"/>
	</message>
	<message name="subdivisionMercanciaRequest">
		<part name="parameters" type="tns:subdivisionMercancia"/>
	</message>
	<message name="subdivisionMercanciaResponse">
		<part name="response" type="tns:subdivisionMercanciaResponse"/>
	</message>
	<message name="traspaleoContenedorRequest">
		<part name="parameters" type="tns:traspaleoContenedor"/>
	</message>
	<message name="traspaleoContenedorResponse">
		<part name="response" type="tns:traspaleoContenedorResponse"/>
	</message>
	<message name="incidenciaMercanciaRequest">
		<part name="parameters" type="tns:incidenciaMercancia"/>
	</message>
	<message name="incidenciaMercanciaResponse">
		<part name="response" type="tns:incidenciaMercanciaResponse"/>
	</message>
	<message name="salidaTransferenciaRequest">
		<part name="parameters" type="tns:salidaTransferencia"/>
	</message>
	<message name="salidaTransferenciaResponse">
		<part name="response" type="tns:salidaTransferenciaResponse"/>
	</message>
	<message name="traspasoMercanciaRequest">
		<part name="parameters" type="tns:traspasoMercancia"/>
	</message>
	<message name="traspasoMercanciaResponse">
		<part name="response" type="tns:traspasoMercanciaResponse"/>
	</message>
	<message name="ceAgregacionMercanciaRequest">
		<part name="parameters" type="tns:ceAgregacionMercancia"/>
	</message>
	<message name="ceAgregacionMercanciaResponse">
		<part name="response" type="tns:ceAgregacionMercanciaResponse"/>
	</message>
	<message name="ceDesagregacionMercanciaRequest">
		<part name="parameters" type="tns:ceDesagregacionMercancia"/>
	</message>
	<message name="ceDesagregacionMercanciaResponse">
		<part name="response" type="tns:ceDesagregacionMercanciaResponse"/>
	</message>
	<portType name="OperacionEntrada">
		<operation name="notificacionIngresoMercancia">
			<input message="tns:notificacionIngresoMercanciaRequest"/>
			<output message="tns:notificacionIngresoMercanciaResponse"/>
		</operation>
		<operation name="ingresoSinID">
			<input message="tns:ingresoSinIDRequest"/>
			<output message="tns:ingresoSinIDResponse"/>
		</operation>
		<operation name="ingresoSimple">
			<input message="tns:ingresoSimpleRequest"/>
			<output message="tns:ingresoSimpleResponse"/>
		</operation>
		<operation name="ingresoParcial">
			<input message="tns:ingresoParcialRequest"/>
			<output message="tns:ingresoParcialResponse"/>
		</operation>
		<operation name="rechazo">
			<input message="tns:rechazoRequest"/>
			<output message="tns:rechazoResponse"/>
		</operation>
		<operation name="ingresoFlujoAlterno">
			<input message="tns:ingresoFlujoAlternoRequest"/>
			<output message="tns:ingresoFlujoAlternoResponse"/>
		</operation>
		<operation name="salidaPedimento">
			<input message="tns:salidaPedimentoRequest"/>
			<output message="tns:salidaPedimentoResponse"/>
		</operation>
		<operation name="desconsolidacionMaster">
			<input message="tns:desconsolidacionMasterRequest"/>
			<output message="tns:desconsolidacionMasterResponse"/>
		</operation>
		<operation name="consolidacionMaster">
			<input message="tns:consolidacionMasterRequest"/>
			<output message="tns:consolidacionMasterResponse"/>
		</operation>
		<operation name="subdivisionMercancia">
			<input message="tns:subdivisionMercanciaRequest"/>
			<output message="tns:subdivisionMercanciaResponse"/>
		</operation>
		<operation name="traspaleoContenedor">
			<input message="tns:traspaleoContenedorRequest"/>
			<output message="tns:traspaleoContenedorResponse"/>
		</operation>
		<operation name="incidenciaMercancia">
			<input message="tns:incidenciaMercanciaRequest"/>
			<output message="tns:incidenciaMercanciaResponse"/>
		</operation>
		<operation name="salidaTransferencia">
			<input message="tns:salidaTransferenciaRequest"/>
			<output message="tns:salidaTransferenciaResponse"/>
		</operation>
		<operation name="traspasoMercancia">
			<input message="tns:traspasoMercanciaRequest"/>
			<output message="tns:traspasoMercanciaResponse"/>
		</operation>
		<operation name="ceAgregacionMercancia">
			<input message="tns:ceAgregacionMercanciaRequest"/>
			<output message="tns:ceAgregacionMercanciaResponse"/>
		</operation>
		<operation name="ceDesagregacionMercancia">
			<input message="tns:ceDesagregacionMercanciaRequest"/>
			<output message="tns:ceDesagregacionMercanciaResponse"/>
		</operation>
	</portType>
	<binding name="OperacionEntradaPortBinding" type="tns:OperacionEntrada">
		<soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http"/>
		<operation name="notificacionIngresoMercancia">
			<soap:operation soapAction="{{ $soapAction }}/notificacionIngresoMercancia" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="ingresoSinID">
			<soap:operation soapAction="{{ $soapAction }}/ingresoSinID" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="ingresoSimple">
			<soap:operation soapAction="{{ $soapAction }}/ingresoSimple" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="ingresoParcial">
			<soap:operation soapAction="{{ $soapAction }}/ingresoParcial" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="rechazo">
			<soap:operation soapAction="{{ $soapAction }}/rechazo" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="ingresoFlujoAlterno">
			<soap:operation soapAction="{{ $soapAction }}/ingresoFlujoAlterno" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="salidaPedimento">
			<soap:operation soapAction="{{ $soapAction }}/salidaPedimento" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="desconsolidacionMaster">
			<soap:operation soapAction="{{ $soapAction }}/desconsolidacionMaster" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="consolidacionMaster">
			<soap:operation soapAction="{{ $soapAction }}/consolidacionMaster" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="subdivisionMercancia">
			<soap:operation soapAction="{{ $soapAction }}/subdivisionMercancia" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="traspaleoContenedor">
			<soap:operation soapAction="{{ $soapAction }}/traspaleoContenedor" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="incidenciaMercancia">
			<soap:operation soapAction="{{ $soapAction }}/incidenciaMercancia" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="salidaTransferencia">
			<soap:operation soapAction="{{ $soapAction }}/salidaTransferencia" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="traspasoMercancia">
			<soap:operation soapAction="{{ $soapAction }}/traspasoMercancia" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="ceAgregacionMercancia">
			<soap:operation soapAction="{{ $soapAction }}/ceAgregacionMercancia" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
		<operation name="ceDesagregacionMercancia">
			<soap:operation soapAction="{{ $soapAction }}/ceDesagregacionMercancia" style="rpc"/>
			<input>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</input>
			<output>
				<soap:body use="encoded" namespace="" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
			</output>
		</operation>
	</binding>
	<service name="OperacionEntradaService">
		<port name="OperacionEntradaPort" binding="tns:OperacionEntradaPortBinding">
			<soap:address location="{{ $soapAction }}"/>
		</port>
	</service>
</definitions>
