<?php
	/**
	 * Convert HTML to MS Word file
	 * @author Harish Chauhan
	 * @version 1.0.0
	 * @name HTML_TO_DOC
	 */
	
	class HTML_TO_XLS {
		var $xlsFile="";
		var $title="";
		var $htmlHead="";
		var $htmlBody="";
		var $css;
		
		/**
		 * Constructor
		 *
		 * @return void
		 */
		function HTML_TO_XLS(){
			$this->title="Untitled Document";
			$this->htmlHead="";
			$this->htmlBody="";
		}
		
		/**
		 * Set the document file name
		 *
		 * @param String $xlsFile 
		 */
		
		function setXlsFileName($xlsFile){
			$this->xlsFile=$xlsFile;
			if(!preg_match("/\.doc$/i",$this->xlsFile))
				$this->xlsFile.=".xls";
			return;		
		}
		
		function setTitle($title) {
			$this->title=$title;
		}
		
		function setCSS($css){
			$this->css=$css;
		}
		/**
		 * Return header of MS Doc
		 *
		 * @return String
		 */
		function getHeader() {
			$return  = <<<EOH
			<?xml version="1.0"?>
			<?mso-application progid="Excel.Sheet"?>
			<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
			 xmlns:o="urn:schemas-microsoft-com:office:office"
			 xmlns:x="urn:schemas-microsoft-com:office:excel"
			 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
			 xmlns:html="http://www.w3.org/TR/REC-html40">
			  <Styles>
		  <Style ss:ID="Default" ss:Name="Normal">
		   <Alignment ss:Vertical="Bottom"/>
		   <Borders/>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
		   <Interior/>
		   <NumberFormat/>
		   <Protection/>
		  </Style>
		  <Style ss:ID="m48870048">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		  </Style>
		  <Style ss:ID="m48870068">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		  </Style>
		  <Style ss:ID="m48870088">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		  </Style>
		  <Style ss:ID="m48870108">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		  </Style>
		  <Style ss:ID="m48870128">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		  </Style>
		  <Style ss:ID="m48869824">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869844">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869884">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869904">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869924">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869944">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869964">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869600">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869620">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869640">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869660">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869680">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869700">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869456">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="m48869476">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="s62">
		   <Borders/>
		  </Style>
		  <Style ss:ID="s64">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="26" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="s65">
		   <Alignment ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders/>
		  </Style>
		  <Style ss:ID="s67">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders/>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="s69">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="s71">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="24" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="s74">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders/>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Color="#000000"/>
		  </Style>
		  <Style ss:ID="s76">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders/>
		  </Style>
		  <Style ss:ID="s77">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="s92">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="12" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="s94">
		   <Alignment ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="s97">
		   <Alignment ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		  </Style>
		  <Style ss:ID="s98">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		  </Style>
		  <Style ss:ID="s105">
		   <Alignment ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
		     ss:Color="#000000"/>
		   </Borders>
		  </Style>
		  <Style ss:ID="s107">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders/>
		  </Style>
		  <Style ss:ID="s109">
		   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders/>
		  </Style>
		  <Style ss:ID="s111">
		   <Alignment ss:Horizontal="Left" ss:Vertical="Center" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Bottom" ss:LineStyle="Dash" ss:Weight="1"/>
		   </Borders>
		  </Style>
		  <Style ss:ID="s114">
		   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom" ss:WrapText="1"/>
		  </Style>
		  <Style ss:ID="s116">
		   <Alignment ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Borders>
		    <Border ss:Position="Top" ss:LineStyle="Dash" ss:Weight="1"/>
		   </Borders>
		  </Style>
		  <Style ss:ID="s118">
		   <Alignment ss:Vertical="Top" ss:WrapText="1"/>
		  </Style>
		  <Style ss:ID="s120">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
		    ss:Bold="1"/>
		  </Style>
		  <Style ss:ID="s122">
		   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/>
		  </Style>
		 </Styles>
		 <Worksheet ss:Name="SoConverToExecl2191">

EOH;
		return $return;
		}
		
		/**
		 * Return Document footer
		 *
		 * @return String
		 */
		function getFotter(){
			return "</Worksheet></Workbook>";
		}
		
		/**
		 * Create The MS Word Document from given HTML
		 *
		 * @param String $html :: URL Name like http://www.example.com
		 * @param String $file :: Document File Name
		 * @param Boolean $download :: Wheather to download the file or save the file
		 * @return boolean 
		 */
		
		function createXlsFromURL($url,$file,$download=false) {
			if(!preg_match("/^http:/",$url))
				$url="http://".$url;
			$html=@file_get_contents($url);
			return $this->createXls($html,$file,$download);	
		}

		/**
		 * Create The MS Word Document from given HTML
		 *
		 * @param String $html :: HTML Content or HTML File Name like path/to/html/file.html
		 * @param String $file :: Document File Name
		 * @param Boolean $download :: Wheather to download the file or save the file
		 * @return boolean 
		 */
		
		function createXls($html,$file,$download=false) {
			if(is_file($html))
				$html=@file_get_contents($html);
			
			$this->_parseHtml($html);
			$this->setXlsFileName($file);
			$doc=$this->getHeader();
			$doc.=$this->htmlBody;
			$doc.=$this->getFotter();
			if($download) {
				@header("Cache-Control: ");// leave blank to avoid IE errors
				@header("Pragma: ");// leave blank to avoid IE errors
				@header("Content-type: application/vnd.excel");
				@header("Content-Disposition: attachment; filename=\"$this->xlsFile\"");
				echo $doc;
				return true;
			}
			else {
				return $this->write_file($this->xlsFile,$doc);
			}
		}
		
		/**
		 * Parse the html and remove <head></head> part if present into html
		 *
		 * @param String $html
		 * @return void
		 * @access Private
		 */
		
		function _parseHtml($html) {
			$html=preg_replace("/<!DOCTYPE((.|\n)*?)>/ims","",$html);
			$html=preg_replace("/<script((.|\n)*?)>((.|\n)*?)<\/script>/ims","",$html);
			preg_match("/<head>((.|\n)*?)<\/head>/ims",$html,$matches);
			@$head=$matches[1];
			preg_match("/<title>((.|\n)*?)<\/title>/ims",$head,$matches);
			@$this->title = $matches[1];
			$html=preg_replace("/<head>((.|\n)*?)<\/head>/ims","",$html);
			$head=preg_replace("/<title>((.|\n)*?)<\/title>/ims","",$head);
			$head=preg_replace("/<\/?head>/ims","",$head);
			$html=preg_replace("/<\/?body((.|\n)*?)>/ims","",$html);
			
			$this->htmlHead=$head;
			$this->htmlBody=$html;
			return;
		}
		
		/**
		 * Write the content int file
		 *
		 * @param String $file :: File name to be save
		 * @param String $content :: Content to be write
		 * @param [Optional] String $mode :: Write Mode
		 * @return void
		 * @access boolean True on success else false
		 */
		
		function write_file($file,$content,$mode="w"){
			$fp=@fopen($file,$mode);
			if(!is_resource($fp))
				return false;
			fwrite($fp,$content);
			fclose($fp);
			return true;
		}
	}