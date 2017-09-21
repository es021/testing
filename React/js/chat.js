class ChatItem extends React.Component {
	//constant
	static get TYPE_SELF() {return "SELF";}
	static get TYPE_OTHER() {return "OTHER";}
	
	constructor(props) {
		super(props);
	}
		
	render() {
		return ( 
			<div className="chat_item">
				{this.props.type} : {this.props.time} : {this.props.message} 
			</div>		
		);
	}
};

class Chat extends React.Component{
	constructor(props){
		super(props);		
		var data = this.props.data;
		
		//mapping data need key
		this.listItem = data.map((d,i) => <li key={i}><ListItem type = {d.type} message = {d.message}  time = {d.time} /></li>);
															 
	}
	
	render(){
		return(<div className='chat'>{this.listItem}</div>);
	}
};

ReactDOM.render( 
	<App data={data}/>,
	document.getElementById('app')
);	