 <?php
	// Del tree function
	
	function delTree($dir, $conf) 
	{
	    $handler = @opendir($dir);
	    while ($file = @readdir($handler)) {
	    	if ($file != '.' && $file != '..')
	    	{
				if($dir.'/' != $conf && $file[0] != '.')
				{
		        	if( is_dir( $dir.'/'.$file ) )
		            	delTree( $dir.'/'.$file, $conf);
		        	else
		            	@unlink( $dir.'/'.$file );
				}
	    	}
	    }
	  
	  $ret = @rmdir( $dir );
	  return $ret;
	}
	
	// Dir tree function
	// Return in $ret all directory tree or file ftree is $search is set
	
	function dirtree($dir, $f, &$ret, $search=null, $directory=null)
	{
		
		$tree = array();
		$uri = $dir.'/'.$f;
		$uri = str_replace("//", "/", $uri);
		$handler = @opendir($uri);
		//open all directories
		while ($file = @readdir($handler)) 
		{
        	if ($file != '.' && $file != '..')
        	{
        		$items = $dir.'/'.$f;
        		if(is_dir($items.'/'.$file))
        		{
        			if($file[0] !='.')
        			{
	        			if($search == null)
	        				dirtree($items, $file, $tree);
	        			else
	        			{
	        				if($directory != '')
	        					$src = $directory.'/'.$file;
	        				else
	        					$src = $file;
	        				dirtree($items, $file, &$ret,$search, $src);
	        			}
        			}
        		}
        		else if($search != null) // If search mode true
        		{
        			$file_parts = pathinfo($file);
	        		if(strstr(strtolower($file),strtolower($search))) // If search string is in file name
	        		{
	        			if($directory != '') // If root dir
        					$src = $directory.'/'.$file;
        				else
        					$src = $file;
	        			$item = array( 'src' => $src, 'file' => $file); 
	        			if(isset($param))
	        			$param="";
	        			if( @!is_dir($param.$file)) // If not dir and is picture file.
	        			{
	        				
	        				if(strtolower($file_parts['extension']) == 'jpeg' || strtolower($file_parts['extension']) == 'jpg' || strtolower($file_parts['extension']) == 'png' || strtolower($file_parts['extension']) == 'gif' || strtolower($file_parts['extension']) == 'bmp')
	        				{	
	        					$uri = $dir.'/'.$f.'/'.$file;
								$uri = str_replace("//", "/", $uri);
	        					@$size = getimagesize($uri);
	        					@$item['x'] = $size[0];
	        					@$item['y'] = $size[1];
	        					array_push($ret, $item);
	        				}
	        			}
	        		}
        		}
        	}
    	}
    	if($search === null) // Add dir to aray
    	{
    		$it = array('name' => $f,'items' => $tree);
    		array_push($ret,$it);
    	}
	}
	
	// Test Thumbnail dir. If thumbnail not exist is created
	
	function tryThumbnail($config,$param, $file)
	{
		try{
	        $handlerDir = $config['public'].$config['temp_dir'].'.thumbnail/';
	        if (!is_dir($handlerDir))
			{
				if(@mkdir($handlerDir, 0777))
				{
					$create = @chmod($handlerDir, 0777);
				}
			}
	        $lenght = strlen($param);
			if($lenght > 0 && $param[$lenght -1] == '/')
			{
				$paramTest = substr($param, 0, -1);
				if(strlen($paramTest) > 0)
				{
					while($p = strpos($paramTest, '/'))
					{
						$handlerDir .= substr($paramTest,0,$p).'/';
						if (!is_dir($handlerDir))
						{
							if(@mkdir($handlerDir, 0777))
							{
								$create = @chmod($handlerDir, 0777);
							}
						}
						$paramTest = strstr($paramTest, '/');
						$paramTest = substr($paramTest,1);
					}
					$handlerDir .= $paramTest.'/';
					if (!is_dir($handlerDir))
					{
						if(@mkdir($handlerDir, 0777))
						{
							$create = @chmod($handlerDir, 0777);
						}	
					}
				}
			}
	        $thumbnail = resize($config['public'].$config['pictures'].$param.$file, $config['public'].$config['temp_dir'].'.thumbnail/'.$param.$file);
	    }
	    catch(Exception $e)
        {
        	echo '{"picture":[{"src":"ERROR '.$e->getMessage().'","file":"ERROR '.$e->getMessage().'","x":10,"y":10}]}';
        	exit;
        }
	}
	