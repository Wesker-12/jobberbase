<?php
	
	$type_id = get_type_id_by_varname($extra);
	$city_id = false;
	
	/*if ($extra == 'full-time')
	{
		$type_id = JOBTYPE_FULLTIME;
		$city_id = false;
	}
	else if ($extra == 'part-time')
	{
		$type_id = JOBTYPE_PARTTIME;
		$city_id = false;
	}
	else if ($extra == 'freelance')
	{
		$type_id = JOBTYPE_FREELANCE;
		$city_id = false;
	}
	else
	{
		$type_id = false;
		$city_id = false;
	}*/
	
	if($type_id && $id != 'all')
	{
		if ($job->IsValidCategory($id))
		{
			$jobCount =  $job->CountJobs($id, $type_id);
			$smarty->assign('jobs_count', $jobCount);
		}
		else
		{
			redirect_to(BASE_URL . 'page-unavailable/');
			exit;
		}
	}
	
	if (!$type_id && $id != 'all')
	{
		if ($job->IsValidCategory($id))
		{
			
			$jobCount =  $job->CountJobs($id);
			$smarty->assign('jobs_count', $jobCount);
		}
		else
		{
			redirect_to(BASE_URL . 'page-unavailable/');
			exit;
		}
	}
	else if($id == 'all')
	{
		$jobCount =  $job->CountJobs();
		$smarty->assign('jobs_count', $jobCount);
	}
	
	$paginatorLink = BASE_URL . "jobs/$id";
	
	if (isset($extra))
		$paginatorLink .= "/$extra";
		
	$paginator = new Paginator($jobCount, JOBS_PER_PAGE, @$_REQUEST['p']);
	$paginator->setLink($paginatorLink);
	$paginator->paginate();
	
	$firstLimit = $paginator->getFirstLimit();
	$lastLimit = $paginator->getLastLimit();
	
	$the_jobs = array();
	$the_jobs = $job->GetJobsPaginate(0, $id, $firstLimit, JOBS_PER_PAGE, 0, 0, false, $city_id, $type_id);
	$smarty->assign("pages",$paginator->pages_link);
	
	$smarty->assign('jobs', $the_jobs);
	$smarty->assign('types', get_types());
	$smarty->assign('current_category', $id);
	$smarty->assign('current_category_name', get_categ_name_by_varname($id));

	$smarty->assign('seo_title', get_seo_title($id));
	$smarty->assign('seo_desc', get_seo_desc($id));
	$smarty->assign('seo_keys', get_seo_keys($id));

	$template = 'category.tpl';
?>