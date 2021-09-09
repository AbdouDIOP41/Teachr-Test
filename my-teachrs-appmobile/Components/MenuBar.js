import React from 'react';
import { Text, View, StyleSheet} from 'react-native';

class MenuBar extends React.Component {
    render(){
        return (
            <View style={styles.main_container}>

                <View style={styles.title_view}>
                    <Text style={styles.title_text}> Teach'rs Favoris </Text>
                </View>
          </View>
        )
    }
}

const styles = StyleSheet.create({
  main_container : {
    flex: 1,
    backgroundColor:'blue',
    marginTop:-50
  },
  title_view : {
      flex : 1,
      color: 'white',
      alignItems: 'center',
      justifyContent : 'flex-end'
    },

    title_text : {
        color : 'white',
        fontSize : 20,
        marginBottom : 20,
    }

})

export default MenuBar