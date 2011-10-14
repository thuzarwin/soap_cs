<?php

class Application_Model_SoapServer
{
    public $server;
    
    public function __construct() {
        ini_set("soap.wsdl_cache_enabled", "0");
        $this->server = new SoapServer(APPLICATION_PATH."/../library/Sunny/scripts/site_dependent/todo.wsdl", array('trace'=>TRUE));
        
        function getTodoList($filterName){
            $tableLab2 = new Application_Model_DbTable_Lab2();
            $recordList = $tableLab2->fetchAll()->toArray();
            
/*            foreach ($recordList as $record){
            	$oneEntry = new stdClass();
            	$oneEntry->note = $record['text'];
            	$oneEntry->date = $record['time'];
            	$oneEntry->acronym = NULL;
            	$oneEntry->prio = $record['priority'];
            	$oneEntry->id = $record['id'];
            	
            	$aTodoData[] = $oneEntry;
            }
            $getTodoListResult = new stdClass();
            $getTodoListResult->TodoData = $aTodoData;
                  
            $soapVar = new SoapVar($aTodoData, SOAP_ENC_ARRAY, "TodoDataArray", APPLICATION_PATH."/../library/Sunny/scripts/site_dependent/todo.wsdl", "getTodoListResult", APPLICATION_PATH."/../library/Sunny/scripts/site_dependent/todo.wsdl");
*/            
            $getTodoListResultString = "<getTodoListResult type='tns:TodoDataArray'>";
            foreach ($recordList as $record){
            	$note = $record['text'];
            	$date = $record['time'];
            	$acronym = NULL;
            	$prio = $record['priority'];
            	$id = $record['id'];
                
                $oneTodoData = "<TodoData><note xsi:type='xs:string'>$note</note><date xsi:type='xs:string'>$date</date><acro xs:null='1'/><prio xsi:type='xs:int'>$prio</prio><id xsi:type='xs:int'>$id</id></TodoData>";
                $getTodoListResultString .= $oneTodoData;
            }
            $getTodoListResultString .= "</getTodoListResult>";
            $soapVar = new SoapVar($getTodoListResultString, XSD_ANYXML);
            return $soapVar;
        }
        
        function createTodo($input){
        	$output = "create todo";
        	return($output);
        }
        
        
        $this->server->addFunction("getTodoList");
        $this->server->addFunction("createTodo");
        
    }
    

        

}

