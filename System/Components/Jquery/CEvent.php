<?php
/************************************************************/
/*                    COMPONENT  EVENT                   	*/
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
namespace Jquery;

require_once(COMPONENTS_DIR.'Jquery/Common.php');

use Jquery\ComponentJqueryCommon;
/******************************************************************************************
* EVENT                                                                                   *
*******************************************************************************************
| Dahil(Import) Edilirken : CEvent     							     			  		  |
| Sınıfı Kullanırken      :	$this->cevent->       									      |
| 																						  |
| Kütüphanelerin kısa isimlendirmelerle kullanımı için. Config/Libraries.php bakınız.     |
******************************************************************************************/
class CEvent extends ComponentJqueryCommon
{
	/* Selector Variables
	 * Selector 
	 * this, #custom, .example
	 *
	 * $(this), $("#custom"), $(".example") 
	 */
	protected $selector = 'this';
	
	/* Type Variables
	 * Event Types
	 * click, mouseover, keyup, ...
	 *
	 * bind('click'), bind('mouseover'), bind('keyup'), ...
	 */
	protected $type		= '';
	
	/* Callback Variables
	 * Data Function
	 * alert("example");
	 *
	 * function(data){alert("example");}
	 */
	protected $callback = '';
	
	/* Property Variables
	 * Property
	 * live, bind, unbind...
	 *
	 * .live(), .bind(), .unbind()
	 */
	protected $property = 'bind';
	
	/* Selector Function
	 * Params: string @selector 
	 * this, #custom, .example
	 *
	 * $(this), $("#custom"), $(".example") 
	 */
	public function selector($selector = '')
	{
		if( ! is_char($selector))
		{
			return $this;	
		}
		
		if($this->_is_key_selector($selector))
		{
			$this->selector = $selector;	
		}
		else
		{
			$this->selector = "\"$selector\"";	
		}
		return $this;
	}
	
	/* Protected Event
	 * Params: string @type, string @selector, string @callback 
	 * 
	 *
	 * 
	 */
	protected function _event($type = '', $selector = '', $callback = '')
	{
		$this->property($type);$type;
		
		if( ! empty($selector))
		{
			$this->selector($selector);	
		}
		
		if( ! empty($callback))
		{
			$this->callback('e', $callback);	
		}
	}
	
	/* Click Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: click, @callback: 'alert("example");'
	 * 
	 * 'click', 'function(e){alert("example");}'
	 */
	public function click($selector = '', $callback = '')
	{
		$this->_event('click', $selector, $callback);
		
		return $this;
	}
	
	/* Blur Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: blur, @callback: 'alert("example");'
	 * 
	 * 'blur', 'function(e){alert("example");}'
	 */
	public function blur($selector = '', $callback = '')
	{
		$this->_event('blur', $selector, $callback);
		
		return $this;
	}
	
	/* Change Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: change, @callback: 'alert("example");'
	 * 
	 * 'change', 'function(e){alert("example");}'
	 */
	public function change($selector = '', $callback = '')
	{
		$this->_event('change', $selector, $callback);
		
		return $this;
	}
	
	/* Double Click Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: dblclick, @callback: 'alert("example");'
	 * 
	 * 'dblclick', 'function(e){alert("example");}'
	 */
	public function dblclick($selector = '', $callback = '')
	{
		$this->_event('dblclick', $selector, $callback);
		
		return $this;
	}
	
	/* Error Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: error, @callback: 'alert("example");'
	 * 
	 * 'error', 'function(e){alert("example");}'
	 */
	public function error($selector = '', $callback = '')
	{
		$this->_event('error', $selector, $callback);
		
		return $this;
	}
	
	/* Resize Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: resize, @callback: 'alert("example");'
	 * 
	 * 'resize', 'function(e){alert("example");}'
	 */
	public function resize($selector = '', $callback = '')
	{
		$this->_event('resize', $selector, $callback);
		
		return $this;
	}
	
	/* Scroll Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: scroll, @callback: 'alert("example");'
	 * 
	 * 'scroll', 'function(e){alert("example");}'
	 */
	public function scroll($selector = '', $callback = '')
	{
		$this->_event('scroll', $selector, $callback);
		
		return $this;
	}
	
	/* Load Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: load, @callback: 'alert("example");'
	 * 
	 * 'load', 'function(e){alert("example");}'
	 */
	public function load($selector = '', $callback = '')
	{
		$this->_event('load', $selector, $callback);
		
		return $this;
	}
	
	/* Unload Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: unload, @callback: 'alert("example");'
	 * 
	 * 'unload', 'function(e){alert("example");}'
	 */
	public function unload($selector = '', $callback = '')
	{
		$this->_event('unload', $selector, $callback);
		
		return $this;
	}
	
	/* Focus Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: focus, @callback: 'alert("example");'
	 * 
	 * 'focus', 'function(e){alert("example");}'
	 */
	public function focus($selector = '', $callback = '')
	{
		$this->_event('focus', $selector, $callback);
		
		return $this;
	}
	
	/* Focus In Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: focusin, @callback: 'alert("example");'
	 * 
	 * 'focusin', 'function(e){alert("example");}'
	 */
	public function focusin($selector = '', $callback = '')
	{
		$this->_event('focusin', $selector, $callback);
		
		return $this;
	}
	
	/* Focus Out Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: focusout, @callback: 'alert("example");'
	 * 
	 * 'focusout', 'function(e){alert("example");}'
	 */
	public function focusout($selector = '', $callback = '')
	{
		$this->_event('focusout', $selector, $callback);
		
		return $this;
	}
	
	/* Select Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: select, @callback: 'alert("example");'
	 * 
	 * 'select', 'function(e){alert("example");}'
	 */
	public function select($selector = '', $callback = '')
	{
		$this->_event('select', $selector, $callback);
		
		return $this;
	}
	
	/* Submit Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: submit, @callback: 'alert("example");'
	 * 
	 * 'submit', 'function(e){alert("example");}'
	 */
	public function submit($selector = '', $callback = '')
	{
		$this->_event('submit', $selector, $callback);
		
		return $this;
	}
	
	/* Keydown Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: keydown, @callback: 'alert("example");'
	 * 
	 * 'keydown', 'function(e){alert("example");}'
	 */
	public function keydown($selector = '', $callback = '')
	{
		$this->_event('keydown', $selector, $callback);
		
		return $this;
	}
	
	/* Keypress Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: keypress, @callback: 'alert("example");'
	 * 
	 * 'keypress', 'function(e){alert("example");}'
	 */
	public function keypress($selector = '', $callback = '')
	{
		$this->_event('keypress', $selector, $callback);
		
		return $this;
	}
	
	/* Keyup Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: keyup, @callback: 'alert("example");'
	 * 
	 * 'keyup', 'function(e){alert("example");}'
	 */
	public function keyup($selector = '', $callback = '')
	{
		$this->_event('keyup', $selector, $callback);
		
		return $this;
	}
	
	/* Hover Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: hover, @callback: 'alert("example");'
	 * 
	 * 'hover', 'function(e){alert("example");}'
	 */
	public function hover($selector = '', $callback = '')
	{
		$this->_event('hover', $selector, $callback);
		
		return $this;
	}
	
	/* Mouse Down Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: mousedown, @callback: 'alert("example");'
	 * 
	 * 'mousedown', 'function(e){alert("example");}'
	 */
	public function mousedown($selector = '', $callback = '')
	{
		$this->_event('mousedown', $selector, $callback);
		
		return $this;
	}
	
	/* Mouse Enter Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: mouseenter, @callback: 'alert("example");'
	 * 
	 * 'mouseenter', 'function(e){alert("example");}'
	 */
	public function mouseenter($selector = '', $callback = '')
	{
		$this->_event('mouseenter', $selector, $callback);
		
		return $this;
	}
	
	/* Mouse Leave Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: mouseleave, @callback: 'alert("example");'
	 * 
	 * 'mouseleave', 'function(e){alert("example");}'
	 */
	public function mouseleave($selector = '', $callback = '')
	{
		$this->_event('mouseleave', $selector, $callback);
		
		return $this;
	}
	
	/* Mouse Move Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: mousemove, @callback: 'alert("example");'
	 * 
	 * 'mousemove', 'function(e){alert("example");}'
	 */
	public function mousemove($selector = '', $callback = '')
	{
		$this->_event('mousemove', $selector, $callback);
		
		return $this;
	}
	
	/* Mouse Out Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: mouseout, @callback: 'alert("example");'
	 * 
	 * 'mouseout', 'function(e){alert("example");}'
	 */
	public function mouseout($selector = '', $callback = '')
	{
		$this->_event('mouseout', $selector, $callback);
		
		return $this;
	}
	
	/* Mouse Over Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: mouseover, @callback: 'alert("example");'
	 * 
	 * 'mouseover', 'function(e){alert("example");}'
	 */
	public function mouseover($selector = '', $callback = '')
	{
		$this->_event('mouseover', $selector, $callback);
		
		return $this;
	}
	
	/* Mouse Up Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: mouseup, @callback: 'alert("example");'
	 * 
	 * 'mouseup', 'function(e){alert("example");}'
	 */
	public function mouseup($selector = '', $callback = '')
	{
		$this->_event('mouseup', $selector, $callback);
		
		return $this;
	}
	
	/* Toogle Event
	 * Params: string @selector, string @callback 
	 * 
	 * @selector: toggle, @callback: 'alert("example");'
	 * 
	 * 'toggle', 'function(e){alert("example");}'
	 */
	public function toggle($selector = '', $callback = '')
	{
		$this->_event('toggle', $selector, $callback);
		
		return $this;
	}
	
	/* Event Type Function
	 * Event Types
	 * click, mouseover, keyup, ...
	 *
	 * bind('click'), bind('mouseover'), bind('keyup'), ...
	 */
 	public function type($type = 'click')
	{
		if( ! is_string($type))
		{
			return $this;	
		}
		
		$this->type = $type;
		
		return $this;
	}	
	
	/* Property Type Function
	 * Property Types
	 *
	 * Params: string @property = 'bind'
	 *
	 * .bind, .unbind, trigger, ...
	 *
	 * .bind(), .unbind(), .trigger() ... 
	 */
	public function property($property = 'bind', $attr = array())
	{
		if( ! is_string($property))
		{
			return $this;	
		}
		
		$this->property = $property;
		
		if( ! empty($attr)) 
		{
			$this->type = $this->_params($attr);
		}
		return $this;
	}
	
	/* Attr Function
	 * Attr 
	 *
	 * Params: arg1, arg2, ... argN
	 *
	 * 'click', 'easing' ... 
	 *
	 * ('click', 'easing' ...)
	 */
	public function attr()
	{
		$arguments = func_get_args();
			
		$this->type = $this->_params($arguments);
		
		return $this;
	}
	
	/* Bind Property Function
	 * Bind
	 *
	 * Params: arg1, art2, ... argN
	 *
	 * 'click', '', '' ...
	 *
	 * .bind('click', '', '') 
	 */
	public function bind()
	{
		$arguments = func_get_args();

		$this->property('bind');
		
		$this->type = $this->_params($arguments);
		
		return $this;	
	}
	
	/* Unbind Property Function
	 * Unbind
	 *
	 * Params: arg1, art2, ... argN
	 *
	 * 'click', '', '' ...
	 *
	 * .unbind('click', '', '') 
	 */
	public function unbind()
	{
		$arguments = func_get_args();
		
		$this->property('unbind');
		
		$this->type = $this->_params($arguments);
		
		return $this;	
	}
	
	/* Trigger Property Function
	 * Trigger
	 *
	 * Params: arg1, art2, ... argN
	 *
	 * 'click', '', '' ...
	 *
	 * .trigger('click', '', '') 
	 */
	public function trigger()
	{
		$arguments = func_get_args();
		
		$this->property('trigger');
		
		$this->type = $this->_params($arguments);
		
		return $this;	
	}
	
	/* Trigger Handler Property Function
	 * Trigger Handler
	 *
	 * Params: arg1, art2, ... argN
	 *
	 * 'click', '', '' ...
	 *
	 * .triggerHandler('click', '', '') 
	 */
	public function trigger_handler()
	{
		$arguments = func_get_args();
		
		$this->property('triggerHandler');
		
		$this->type = $this->_params($arguments);
		
		return $this;	
	}
	
	/* Delegate Property Function
	 * Delegate
	 *
	 * Params: arg1, art2, ... argN
	 *
	 * 'click', '', '' ...
	 *
	 * .delegate('click', '', '') 
	 */
	public function delegate()
	{
		$arguments = func_get_args();
		
		$this->property('delegate');
		
		$this->type = $this->_params($arguments);
		
		return $this;	
	}
	
	/* One Property Function
	 * One
	 *
	 * Params: arg1, art2, ... argN
	 *
	 * 'click', '', '' ...
	 *
	 * .one('click', '', '') 
	 */
	public function one()
	{
		$arguments = func_get_args();
		
		$this->property('one');
		
		$this->type = $this->_params($arguments);
		
		return $this;	
	}
	
	/* On Property Function
	 * On
	 *
	 * Params: arg1, art2, ... argN
	 *
	 * 'click', '', '' ...
	 *
	 * .on('click', '', '') 
	 */
	public function on()
	{
		$arguments = func_get_args();
		
		$this->property('on');
		
		$this->type = $this->_params($arguments);
		
		return $this;	
	}
	
	/* Off Property Function
	 * Off
	 *
	 * Params: arg1, art2, ... argN
	 *
	 * 'click', '', '' ...
	 *
	 * .off('click', '', '') 
	 */
	public function off()
	{
		$arguments = func_get_args();
		
		$this->property('off');
		
		$this->type = $this->_params($arguments);
		
		return $this;	
	}
	
	/* Live Property Function
	 * live
	 *
	 * Params: arg1, art2, ... argN
	 *
	 * 'click', '', '' ...
	 *
	 * .live('click', '', '') 
	 */
	public function live()
	{
		$arguments = func_get_args();
		
		$this->property('live');
		
		$this->type = $this->_params($arguments);
		
		return $this;	
	}
	
	/* Remove(Die) Property Function
	 * Remove(Die): die is keyword so It is selected to name remove
	 *
	 * Params: arg1, art2, ... argN
	 *
	 * 'click', '', '' ...
	 *
	 * .die('click', '', '') 
	 */
	public function remove()
	{
		$arguments = func_get_args();
		
		$this->property('die');
		
		$this->type = $this->_params($arguments);
		
		return $this;	
	}
	
	/* Callback Data Function
	 *
	 * Params: string @params, string @callback
	 *
	 * @params: data, event
	 * @callback: alert('custom');
	 *
	 * @return function(data, event){alert('custom');}
	 */
	public function callback($params = '', $callback = '')
	{
		if( ! is_string($callback))
		{
			return $this;	
		}
		
		$this->callback = "function($params)".ln()."{".ln()."\t$callback".ln()."}";
		
		return $this;
	}
	
	/* Callback/Function Data Function
	 *
	 * Params: string @params, string @callback
	 *
	 * @params: data, event
	 * @callback: alert('custom');
	 *
	 * @return function(data, event){alert('custom');}
	 */
	public function func($params = '', $callback = '')
	{
		if( ! is_string($callback))
		{
			return $this;	
		}
		
		$this->callback = "function($params)".ln()."{".ln()."\t$callback".ln()."}";
		
		return $this;
	}
	
	/* Complete Function
	 *
	 * Jquery script completing
	 *
	 */
	public function complete()
	{
		$eventmid = '';
		$event  = ".$this->property";
		$event .= "(";
		if( ! empty($this->type)) $eventmid .= $this->type;
		if( ! empty($this->callback)) $eventmid .= ", $this->callback";
		$event .= trim($eventmid, ',');
		$event .= ")";
		
		$this->_default_variable();
		
		return $event;
	}
	
	/* Create Jquery Function
	 *
	 * Jquery script creating
	 *
	 */
	public function create()
	{
		$combine_event = func_get_args();
		
		$event  = ln()."$($this->selector)";
		$event .= $this->complete();
		if( ! empty($combine_event))foreach($combine_event as $e)
		{			
			$event .= $e;
		}
		
		$event .= ";";
		
		return $event;
	}
	
	/* Default Variable
	 *
	 * 
	 *
	 */
	protected function _default_variable()
	{
		if($this->selector !== 'this') 	$this->selector = 'this';
		if($this->type !== '')  		$this->type		= '';
		if($this->callback !== '')  	$this->callback = '';
		if($this->property !== 'bind')  $this->property 	= 'bind';
	}
}