var carr=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
var narr=['1','2','3','4','5','6','7','8','9','0'];

function validator(str,attr)
{
	var strarr=(str.toUpperCase()).split("");
	var flags=1;
	if(attr=="cs")
	{
		for(var i=0;i<strarr.length;i++)
		{
			if(carr.indexOf(strarr[i])>=0 || strarr[i]==" ")
			{
			}
			else
			{
				flags=0;
			}
		}
	}
	else if(attr=="cn")
	{
		for(var i=0;i<strarr.length;i++)
		{
			if(carr.indexOf(strarr[i])>=0 || narr.indexOf(strarr[i])>=0)
			{
			}
			else
			{
				flags=0;
			}
		}
	}
	else if(attr=="cns")
	{
		for(var i=0;i<strarr.length;i++)
		{
			if(carr.indexOf(strarr[i])>=0 || narr.indexOf(strarr[i])>=0 || strarr[i]==" ")
			{
			}
			else
			{
				flags=0;
			}
		}
	}
	else if(attr=="n")
	{
		for(var i=0;i<strarr.length;i++)
		{
			if(narr.indexOf(strarr[i])>=0)
			{
			}
			else
			{
				flags=0;
			}
		}
	}
	else if(attr=="c")
	{
		for(var i=0;i<strarr.length;i++)
		{
			if(carr.indexOf(strarr[i])>=0)
			{
			}
			else
			{
				flags=0;
			}
		}
	}
	
	if(flags==0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function sort_hoa(hoa_name)
{
	var x=hoa_name.substr(0,4)+"-"+hoa_name.substr(4,2)+"-"+hoa_name.substr(6,3)+"-"+hoa_name.substr(9,2)+"-"+hoa_name.substr(11,2)+"-"+hoa_name.substr(13,3)+"-"+hoa_name.substr(16,3)+"-"+hoa_name.substr(19);
	return x;
}

function getdate(dates)
{
	var tdate=dates.split('-');
	return(tdate[2]+'-'+tdate[1]+'-'+tdate[0]);
}

function get_form_chk(data)
{
	if(data=='y')
	{
		return "Y";
	}
	else if(data=='n')
	{
		return "N";
	}
	else if(data=='a')
	{
		return "N/A";
	}
}