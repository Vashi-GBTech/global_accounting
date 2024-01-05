// JavaScript Document
        function calculation( testName, value, unitId)
		{
	      var testDetailsArr =[];
	      testDetailsArr["rbs"] = {"0":0, "1":1, "2":18.016 };
		  testDetailsArr["ppinsulin"] = {"0":0, "1":1, "2":0.144, "3":1 };
		  testDetailsArr["hb"] = {"0":0, "1":1, "2":0.1 };
		  testDetailsArr["fbs"] = {"0":0, "1":1, "2":18.016 };
		  testDetailsArr["stimulated_cpeptide"] = {"0":0, "1":1, "2":3.020 };
		  testDetailsArr["finsulin"] = {"0":0, "1":1, "2":0.144, "3":1 };
		  testDetailsArr["ppbs"] = {"0":0, "1":1, "2":18.016 };
		  testDetailsArr["t3"] = {"0":0, "1":1, "2":0.065, "3":0.001, "4":0.01 };
		  testDetailsArr["t4"] = {"0":0, "1":1, "2":0.00008, "3":0.001 };
		  testDetailsArr["tsh"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["spth"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["sr_calcium"] = {"0":0, "1":1, "2":4.008 };
		  testDetailsArr["ionised_calcium"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["phosphorus"] = {"0":0, "1":1, "2":3.097, "3":0.1 };
		  testDetailsArr["total_cholesterol"] = {"0":0, "1":1, "2":38.665 };
		  testDetailsArr["vldlc"] = {"0":0, "1":1, "2":0.01 };
		  testDetailsArr["ldlc"] = {"0":0, "1":1, "2":38.665 };
		  testDetailsArr["hdlc"] = {"0":0, "1":1, "2":38.665 };
		  testDetailsArr["tg"] = {"0":0, "1":1, "2":88.574 };
		  testDetailsArr["urinealbumin"] = {"0":0, "1":1 };
		  testDetailsArr["crp"] = {"0":0, "1":1 };
		  testDetailsArr["alkpo4"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["albumin"] = {"0":0, "1":1, "2":0.1 };
		   testDetailsArr["total_proteins"] = {"0":0, "1":1, "2":0.1 };
		  testDetailsArr["tbili"] = {"0":0, "1":1, "2":0.058 };
		  testDetailsArr["dbili"] = {"0":0, "1":1, "2":0.058 };
		  testDetailsArr["ibili"] = {"0":0, "1":1, "2":0.058 };
		  testDetailsArr["sgpt"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["globulin"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["sgot"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["ggt"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["agratio"] = {"0":0, "1":1 };
		  testDetailsArr["sr_iron"] = {"0":0, "1":1, "2":5.585 };
		  testDetailsArr["folic_acid"] = {"0":0, "1":1, "2":44.140, "3":100, "4":100 };
		  testDetailsArr["b12"] = {"0":0, "1":1, "2":1.355, "3":1 };
		  testDetailsArr["tibc"] = {"0":0, "1":1, "2":5.585 };
		  testDetailsArr["tsi"] = {"0":0, "1":1 };
		  testDetailsArr["sferritin"] = {"0":0, "1":1, "2":44.504, "3":100, "4":100 };
		  testDetailsArr["svtd3"] = {"0":0, "1":1, "2":0.385 };
		  testDetailsArr["homocysteine"] = {"0":0, "1":1, "2":0.135, "3":0.000001 };
		  testDetailsArr["screat"] = {"0":0, "1":1, "2":0.011 };
		  testDetailsArr["bun"] = {"0":0, "1":1, "2":2.8 };
		  testDetailsArr["suric_acid"] = {"0":0, "1":1, "2":0.017 };
		  testDetailsArr["na"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["k"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["cl"] = {"0":0, "1":1, "2":1 };
		  testDetailsArr["total_leucocyte_count"] = {"0":0, "1":1, "2":1000000 };
		  testDetailsArr["platelet_count"] = {"0":0, "1":1, "2":1000000 };
		  testDetailsArr["pt"] = {"0" : 0, "1" : 1};
		  testDetailsArr["fibro_scan_cap"] = {"0" : 0, "1" : 1};
		  testDetailsArr["fibro_scan_e"] = {"0" : 0, "1" : 1};
		  testDetailsArr["echo_ef"] = {"0" : 0, "1" : 1};
		  testDetailsArr["urine_routine_pus"] = {"0" : 0, "1" : 1};
		  testDetailsArr["urine_routine_rbcs"] = {"0" : 0, "1" : 1};
		  testDetailsArr["hba1c"] = {"0" : 0, "1" : 1};
		  testDetailsArr["fc_peptide"] = {"0":0, "1":1, "2":3.020 };
		  testDetailsArr["ppc_peptide"] = {"0":0, "1":1, "2":3.020 };
		  testDetailsArr["total_cholesterol"] = {"0":0, "1":1, "2":18.016 };
		 
		  if(!isNaN(value))
		  {
		    $("#"+testName+"_error").hide();
			factor=testDetailsArr[testName][unitId];
			$("#"+testName+"_final").val((value*factor).toFixed(2));
			return 0;
		  }else
		  {
		    $("#"+testName+"_error").show();
			/*$("#"+testName+"").val(0);*/
			$("#"+testName+"_final").val("NULL");
			return 1;
		  }
	    }
        
		function levelCss(testName, levelVal)
		{
	      if(levelVal == "high")
		  {
			$("#"+testName).css('background-color','#f2dede');
			$("#"+testName).css('color','#a94442');
			$("#"+testName+"_final").css('background-color','#f2dede');
			$("#"+testName+"_final").css('color','#a94442');
		  }else if(levelVal == "low")
		  {
		    $("#"+testName).css('background-color','#D9EDF7');
		    $("#"+testName).css('color','#555');
			$("#"+testName+"_final").css('background-color','#D9EDF7');
		    $("#"+testName+"_final").css('color','#555');
		  }else
		  {
		    $("#"+testName).css('background-color','#fff');
		    $("#"+testName).css('color','#555');
			$("#"+testName+"_final").css('background-color','#fff');
		    $("#"+testName+"_final").css('color','#555');
		  }
		}
		
		function levelCheck(testNameArr)
		{
		   errorCount =0;
		   $.each(testNameArr, function( index, testName ) {
			  if($("#"+testName).val()!="" && $("#"+testName).val()!=0)
			  {
				if($("#"+testName+"_level").val()=="" || $("#"+testName+"_level").val()=="NULL")
				{
				  $("#"+testName+"_level_error").show();
				  errorCount = errorCount + 1;
				}else
				{
				  $("#"+testName+"_level_error").hide();
				}
				if($("#"+testName+"_unit").val()=="" || $("#"+testName+"_unit").val()==0)
				{
				  $("#"+testName+"_unit_error").show();
				  errorCount = errorCount + 1;
				}else
				{
				  $("#"+testName+"_unit_error").hide();
				}
			  }else
			  {
				$("#"+testName+"_level_error").hide();
				$("#"+testName+"_unit_error").hide();
			  }
			});
		   if(errorCount==0)
		   {
		    $("#form_error").hide();
		    return true;
		   }else
		   {
		    $("#form_error").show();
		    return false;
		   }
	    }
		
		
		function checktype( testName, value)
		{	 
		  if(!isNaN(value))
		  {
		    $("#"+testName+"_error").hide();
			return 0;
		  }else
		  {
		    $("#"+testName+"_error").show();
			$("#"+testName+"_final").val("NULL");
			return 1;
		  }
	    }