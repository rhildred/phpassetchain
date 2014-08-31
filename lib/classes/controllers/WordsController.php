<?php
class WordsController extends AbstractController
{
  /**
   * GET method.
   *
   * @param  Request $request
   * @return string
   */
  public function get($request)
  {
    $sQuery = $request->url_elements[1];
    $rc = new stdClass();
    $rc->result = "success";
    $rc->matches = ReverseIndex::getMatches($sQuery);
    return $rc;
  }


}
