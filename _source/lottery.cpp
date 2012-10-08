#include<iostream>
#include <cmath>
#include <cstdlib>
#include <ctime>
using namespace std;
// 4 .000456
// 3 .0102341
// 2 0.0965325
// 1 0.3813
// 0 0.511
class ticket{
	
	public:
		ticket(int x, int y);
		bool isInTicket(int x);
		~ticket();
		void showTicket();
		int comp(ticket x);
		int getNum(int x);
	private:
		int maxnum;
		int ticketsize;
		int *aticket;		
};
int ticket::getNum(int x){return aticket[x];}

int ticket::comp(ticket x){
	int cnt=0;
	for (int i=0;i<ticketsize;i++){
		if(x.isInTicket(getNum(i))){cnt++;} 
	}
	return cnt;

}

ticket::ticket(int x, int y){
	maxnum=x;
	ticketsize=y;
	aticket = new int[maxnum];
	int size=1;
	aticket[0]=rand()%60;
	int tmp;
	while (size<ticketsize){
		tmp=rand()%maxnum;
		if (!isInTicket(tmp)){aticket[size]=tmp; size++;}

	}


}
ticket::~ticket(){

	delete aticket;
}

bool ticket::isInTicket(int x){
	bool isIn=false;
	for (int i=0;i<ticketsize;i++){
		if (aticket[i]==x){isIn=true;}
	}
	return isIn;
}

void ticket::showTicket(){
	for (int i=0;i<ticketsize;i++){
		cout<<aticket[i];
		if (i!=5){cout <<", ";}

	}
	cout <<endl;
}

int main(){
	srand(time(NULL));
	ticket a=ticket(60,6);
	ticket *myTicket;
	int hits=0;
	int nums=0;
	double rat;
	while(true){
		nums++;
		myTicket=new ticket(60,6);
		if (a.comp(*myTicket)==0){hits++;}
		rat=(double) hits/ (double) nums;
		cout <<"hits: "<<hits<<" nums: "<<nums<< "prop: "<<rat<<endl;
	}

}
