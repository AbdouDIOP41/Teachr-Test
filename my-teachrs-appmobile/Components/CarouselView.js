import * as React from 'react';
import { Text, View, SafeAreaView, StyleSheet} from 'react-native';
import Teachrs from './TeachrsData'
import Carousel from 'react-native-snap-carousel';
import MenuBar from './MenuBar';

export default class CarouselView extends React.Component {

 
    constructor(props){
        super(props);
        this.state = {
          activeIndex:0,
          //data : []
          carouselItems: Teachrs
      }
      console.log(this.state.carouselItems)
    }

    _renderItem({item,index}){
        return (
          <View style={{
              backgroundColor:'white',
              borderRadius: 5,
              borderWidth: 2,
              borderColor : 'gray',
              height: 400,
              justifyContent : 'center',
              alignItems : 'center',
              marginLeft: 25,
              marginRight: 25, 
              marginTop : 50
              }}>
            <Text style={{fontSize: 30}}>{item.title}</Text>
            <Text> Formation{"\n"} {item.formation}</Text>
            <View>
              <Text> {item.Description}</Text>
            </View>
          </View>

        )
    }

    render() {
        return (
          <SafeAreaView style={{flex: 1 }}>
            <MenuBar></MenuBar>

            <View style={styles.main_carousel}>
                <Carousel
                  layout={"default"}
                  ref={ref => this.carousel = ref}
                  data={this.state.carouselItems}
                  sliderWidth={400}
                  itemWidth={300}
                  renderItem={this._renderItem}
                  onSnapToItem = { index => this.setState({activeIndex:index}) } />
            </View>
          </SafeAreaView>
        );
    }
}

const styles = StyleSheet.create({
  main_carousel : {
     flex: 3, flexDirection:'row', justifyContent: 'center', 
  },
  title_text : {
      color: 'white',
      justifyContent:'end',
      alignItems: 'center',
      justifyContent: 'center',
  }
  
})
