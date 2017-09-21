class ListItem extends React.Component {
	constructor(props){
		super(props);
		
		//declare state
		this.state = {
			count : 0,
			value : props.value
		};
		
		//bind event
		this.addCount = this.addCount.bind(this);
		this.minusCount = this.minusCount.bind(this);
		
	}
	
	componentDidMount(){
		this.countInterval = setInterval(()=>this.addCount(),1000);
	}
	
	componentWillUnmount(){
		clearInterval(this.countInterval);
	}
	
	addCount(){
		this.setState((prevState) => ({
			count : prevState.count + 1
		}));
	}
	
	minusCount(){
		this.setState((prevState) => ({
			count : prevState.count - 1
		}));
	}
	
	render() {
		return ( 
			<div>
				{this.state.value} : {this.props.title} - {this.state.count}
				
				{this.state.count <= 5 ? 
					<button onClick={this.addCount}>Add</button>
			 	:
					<button onClick={this.minusCount}>Minus</button>
				}
				
			</div>		
		);
	}
};

class App extends React.Component{
	constructor(props){
		super(props);		
		var data = this.props.data;
		
		//mapping data need key
		this.listItem = data.map((d,i) => <li key={i}><ListItem title = {d.name} value = {d.number} /></li>);
															 
	}
	
	render(){
		return(<div>
				<ul className='my_list'>{this.listItem}</ul>
			</div>);
	}
};

			   
/**** SERVICE ********************************************/
	
var Service = function (url) {
    this.url = url;
	this.specialKey = "not_jQuery";
};

Service.prototype.postAjax = function (data, success, error) {

	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	xhr.open('POST', this.url);
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	
	xhr.onreadystatechange = function () {
		if (xhr.readyState > 3) {
			if (xhr.status == 200) {
				try{
					var res = JSON.parse(xhr.responseText);
					success(res);

				}catch(err){
					error(err);
				}
			}
		}
	};

	var param = this.specialKey + "=" + JSON.stringify(data)
	xhr.send(param);
	return xhr;
};

/**** MAIN ********************************************/

var SMSBlastService = new Service ("http://localhost/SMSBlastWebService/");
var data = {action: "get_contacts", data: {page: 1}};
		
SMSBlastService.postAjax(data,
	function (res) {
		console.log(res);
		var data = res.data;
		ReactDOM.render( 
			<App data={data}/>,
			document.getElementById('app')
		);
	},
	function (err) {
		console.log(err);
	}
);

var data = {action: "get_contacts", data: {page: 2}};

SMSBlastService.postAjax(data,
	function (res) {
		console.log(res);

	},
	function (err) {
		console.log(err);
	}
);


